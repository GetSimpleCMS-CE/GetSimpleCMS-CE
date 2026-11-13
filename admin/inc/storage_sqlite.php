<?php
/**
 * SQLite storage backend for GetSimple CMS-CE.
 *
 * Optional alternative to the default XML file storage. When GSDATABASE is
 * set to 'sqlite', getXML()/XMLsave() route through this class instead of
 * reading/writing XML files on disk. XML files are still kept as a mirror
 * for plugin compatibility (plugins that read XML directly keep working).
 *
 * @package GetSimple
 * @subpackage Storage
 */

if (!class_exists('GS_Storage_SQLite')) {
    class GS_Storage_SQLite {
        protected $db;
        protected $dbPath;

        public function __construct($dbPath) {
            $this->dbPath = $dbPath;
            $dir = dirname($dbPath);
            if (!is_dir($dir)) { @mkdir($dir, 0755, true); }
            $this->db = new SQLite3($dbPath);
            $this->db->busyTimeout(5000);
            $this->ensureSchema();
        }

        protected function ensureSchema() {
            $this->db->exec('CREATE TABLE IF NOT EXISTS gs_storage (
                path TEXT PRIMARY KEY,
                content TEXT NOT NULL,
                mtime INTEGER NOT NULL
            )');
            $this->db->exec('CREATE INDEX IF NOT EXISTS idx_gs_storage_path ON gs_storage(path)');
        }

        public function get($path) {
            $stmt = $this->db->prepare('SELECT content FROM gs_storage WHERE path = :p');
            $stmt->bindValue(':p', $path, SQLITE3_TEXT);
            $res = $stmt->execute();
            $row = $res->fetchArray(SQLITE3_ASSOC);
            return ($row && isset($row['content'])) ? $row['content'] : false;
        }

        public function put($path, $content) {
            $stmt = $this->db->prepare('INSERT INTO gs_storage (path, content, mtime) VALUES (:p, :c, :m)
                ON CONFLICT(path) DO UPDATE SET content = :c, mtime = :m');
            $stmt->bindValue(':p', $path, SQLITE3_TEXT);
            $stmt->bindValue(':c', $content, SQLITE3_TEXT);
            $stmt->bindValue(':m', time(), SQLITE3_INTEGER);
            return $stmt->execute() !== false;
        }

        public function exists($path) {
            $stmt = $this->db->prepare('SELECT 1 FROM gs_storage WHERE path = :p');
            $stmt->bindValue(':p', $path, SQLITE3_TEXT);
            $res = $stmt->execute();
            $row = $res->fetchArray(SQLITE3_ASSOC);
            return (bool)$row;
        }

        public function delete($path) {
            $stmt = $this->db->prepare('DELETE FROM gs_storage WHERE path = :p');
            $stmt->bindValue(':p', $path, SQLITE3_TEXT);
            return $stmt->execute() !== false;
        }

        public function listPrefix($prefix) {
            $out = array();
            $stmt = $this->db->prepare('SELECT path FROM gs_storage WHERE path LIKE :p');
            $stmt->bindValue(':p', $prefix . '%', SQLITE3_TEXT);
            $res = $stmt->execute();
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $out[] = $row['path'];
            }
            return $out;
        }

        public function exportToDisk($root) {
            $root = rtrim(str_replace('\\', '/', $root), '/');
            $count = 0;
            $res = $this->db->query('SELECT path, content FROM gs_storage');
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $rel = str_replace('\\', '/', $row['path']);
                if (strpos($rel, '..') !== false) continue;
                $full = $root . '/' . ltrim($rel, '/');
                $dir = dirname($full);
                if (!is_dir($dir)) { @mkdir($dir, 0755, true); }
                if (@file_put_contents($full, $row['content']) !== false) { $count++; }
            }
            return $count;
        }

        public function migrateFromDisk($root) {
            $root = rtrim(str_replace('\\', '/', $root), '/');
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS));
            $count = 0;
            foreach ($it as $file) {
                if (!$file->isFile()) continue;
                $full = str_replace('\\', '/', $file->getRealPath());
                // never import the database file itself
                if (preg_match('/database\.sqlite(-wal|-shm)?$/', $full)) continue;
                if (defined('GSROOTPATH') && function_exists('gs_storage_relative_path')) {
                    $rel = gs_storage_relative_path($full);
                } else {
                    $rel = 'data/' . substr($full, strlen($root) + 1);
                }
                $content = @file_get_contents($full);
                if ($content === false) continue;
                if ($this->put($rel, $content)) {
                    $count++;
                    // Remove the XML source file once imported so sqlite mode
                    // does not keep a full XML copy on disk.
                    if (strtolower(pathinfo($full, PATHINFO_EXTENSION)) === 'xml') {
                        @unlink($full);
                    }
                }
            }
            return $count;
        }
    }
}

function gs_storage_sqlite() {
    if (isset($GLOBALS['GS_STORAGE_SQLITE']) && $GLOBALS['GS_STORAGE_SQLITE'] instanceof GS_Storage_SQLite) {
        return $GLOBALS['GS_STORAGE_SQLITE'];
    }
    return null;
}

if (!function_exists('gs_storage_mode')) {
    function gs_storage_mode() {
        return defined('GSDATABASE') ? GSDATABASE : 'xml';
    }
}
