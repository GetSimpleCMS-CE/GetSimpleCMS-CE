<?php
/*
 * Application Programming Interface Plugin
 * 
 * @author Chris Cagle
 */

class API_Request {

	var $xml;

	/* 
	 * Authenticate
	 * 
	 * @param string
	 * @return bool
	 */	
	private function auth() {
		$appid_file = getXML(GSDATAOTHERPATH.'appid.xml');
		if ($appid_file->status == 'true') {
			$stored   = (string)$appid_file->key;
			$supplied = (string)$this->xml->key;
			if ($stored !== '' && $supplied !== '' && hash_equals($stored, $supplied)) {
				return true;
			} else {
				$message = ['status' => 'error', 'message' => i18n_r('API_ERR_AUTHFAILED')];
				echo json_encode($message);
			}
		} else {
			$message = ['status' => 'error', 'message' => i18n_r('API_ERR_AUTHDISABLED')];
			echo json_encode($message);
		}
		return false;
	}

	/*
	 * Validate a page slug. Only plain filename characters are allowed.
	 *
	 * @param mixed
	 * @return string|false
	 */
	private function clean_slug($raw) {
		$slug = (string)$raw;
		if ($slug === '' || strlen($slug) > 255) return false;
		if (!preg_match('/^[A-Za-z0-9._-]+$/', $slug)) return false;
		if ($slug[0] === '.' || strpos($slug, '..') !== false) return false;
		return $slug;
	}

	/*
	 * GSDATAPAGESPATH (defense in depth against symlinks etc.).
	 *
	 * @param string validated slug
	 * @return string|false full path, or false if missing/outside
	 */
	private function page_file($slug) {
		$base = realpath(GSDATAPAGESPATH);
		$real = realpath(GSDATAPAGESPATH.$slug.'.xml');
		if ($base === false || $real === false) return false;
		if (strpos($real, $base.DIRECTORY_SEPARATOR) !== 0) return false;
		return $real;
	}

	/*
	 * Normalize a relative upload sub-path.
	 *
	 * @param mixed
	 * @return string|false relative path without leading slash, e.g. "images/2024"
	 */
	private function clean_upload_subpath($raw) {
		$p = (string)$raw;
		if (strpos($p, "\0") !== false) return false;
		$p = str_replace('\\', '/', $p);
		$clean = [];
		foreach (explode('/', $p) as $seg) {
			if ($seg === '') continue;
			if ($seg === '.' || $seg === '..') return false;
			$clean[] = $seg;
		}
		return implode('/', $clean);
	}

	/*
	 * Resolve an upload directory and confirm it is inside GSDATAUPLOADPATH.
	 *
	 * @param string cleaned sub-path
	 * @return string|false directory path with trailing slash
	 */
	private function upload_dir($sub) {
		$base = realpath(GSDATAUPLOADPATH);
		$real = realpath(GSDATAUPLOADPATH.$sub);
		if ($base === false || $real === false || !is_dir($real)) return false;
		if ($real !== $base && strpos($real, $base.DIRECTORY_SEPARATOR) !== 0) return false;
		return tsl($real);
	}

	/*
	 * Build the page index ($pagesArray format) straight from data/pages/*.xml.
	 *
	 * @return array
	 */
	private function load_pages_index() {
		$index = [];
		$files = glob(GSDATAPAGESPATH.'*.xml');
		if ($files === false) return $index;
		foreach ($files as $file) {
			$data = getXML($file);
			if (!$data) continue;
			$page = [];
			foreach (['title', 'menu', 'menuOrder', 'parent', 'url', 'menuStatus', 'private', 'pubDate'] as $k) {
				$page[$k] = (string)$data->$k;
			}
			if ($page['url'] === '') $page['url'] = basename($file, '.xml');
			$page['filename'] = basename($file);
			$index[] = $page;
		}
		return $index;
	}

	public function add_data($array) {
		$this->xml = $array;
	}

	/* 
	 * Read Page
	 * 
	 * @return json
	 */	
	public function page_read() {
		if($this->auth()) {
			$id = $this->clean_slug($this->xml->data->slug);
			if ($id === false) {
				return json_encode(['status' => 'error', 'message' => 'Invalid page slug']);
			}
			$file = $this->page_file($id);
			if ($file !== false) {
				$page = getXML($file);
				$page->content = strip_decode($page->content);
				$page->metak = strip_decode($page->metak);
				$page->metad = strip_decode($page->metad);
				$page->title = strip_decode($page->title);
				$wrapper = ['status' => 'success', 'message' => 'page_read ok', 'response' => $page];
				return json_encode($wrapper);
			} else {
				$error = ['status' => 'error', 'message' => sprintf(i18n_r('API_ERR_NOPAGE'), $id)];
				return json_encode($error);
			}
		}
	}

	/* 
	 * Read Settings
	 * 
	 * @return json
	 */
	public function settings_read() {
		if($this->auth()) {
			$settings = getXML(GSDATAOTHERPATH.'website.xml');
			$wrapper = ['status' => 'success', 'message' => 'settings_read ok', 'response' => $settings];
			return json_encode($wrapper);
		}
	}

	/* 
	 * Read All Pages
	 * 
	 * @return json
	 */
	public function all_pages_read() {
		if($this->auth()) {
			global $pagesArray;
			if (empty($pagesArray)) $pagesArray = $this->load_pages_index();
			$pages = get_available_pages();
			$wrapper = ['status' => 'success', 'message' => 'all_pages_read ok', 'response' => $pages];
			return json_encode($wrapper);
		}
	}

	/* 
	 * Upload File
	 * 
	 * @return bool
	 */
	public function file_upload() {
		if($this->auth()) {

			$sub = $this->clean_upload_subpath($this->xml->data->path);
			if ($sub === false) {
				return json_encode(['status' => 'error', 'message' => 'Invalid path']);
			}
			$path = tsl(GSDATAUPLOADPATH . $sub);

		}
	}

	/* 
	 * Save Page
	 * 
	 * @return bool
	 */
	public function page_save() {
		if($this->auth()) {
			$id = $this->clean_slug($this->xml->data->slug);
			if ($id === false) {
				return json_encode(['status' => 'error', 'message' => 'Invalid page slug']);
			}
			$thisfile = $this->page_file($id);
			if ($thisfile !== false) {
				$page = getXML($thisfile);
				$page->content = safe_slash_html($this->xml->data->content);
				$page->title = safe_slash_html($this->xml->data->title);
				$page->pubDate = date('r');
				$bakfile = GSBACKUPSPATH."pages/". $id .".bak.xml";
				copy($thisfile, $bakfile);
				$status = XMLsave($page, $thisfile);
				if ($status) {
					touch($thisfile);
					$wrapper = ['status' => 'success', 'message' => 'page_save ok', 'response' => $page];
				} else {
					$wrapper = ['status' => 'error', 'message' => 'There was an error saving your page'];
				}
				return json_encode($wrapper);
			} else {
				$error = ['status' => 'error', 'message' => sprintf(i18n_r('API_ERR_NOPAGE'), $id)];
				return json_encode($error);
			}
		}
	}

	/* 
	 * Read Files
	 * 
	 * @return json
	 */
	public function all_files_read() {
		if($this->auth()) {
			$patho = $this->clean_upload_subpath($this->xml->data->path);
			if ($patho === false) {
				return json_encode(['status' => 'error', 'message' => 'Invalid path']);
			}
			$path = $this->upload_dir($patho);
			if ($path === false) {
				return json_encode(['status' => 'error', 'message' => 'Invalid path']);
			}
			$filesArray = [];
			$count =0;
			global $SITEURL;

			$filenames = getFiles($path);
			if (count($filenames) != 0) { 
				foreach ($filenames as $file) {
					if ($file == "." || $file == ".." || $file == ".htaccess" ){
				    // not a upload file
				  } else {

				  	$filesArray[$count]['name'] = $file;
				  	if (is_dir($path . $file)) {
					    $filesArray[$count]['type'] = 'folder';
						} else {
							$filesArray[$count]['type'] = 'file';
							$filesArray[$count]['url'] = tsl($SITEURL.'data/uploads/'.$patho).$file;
								$ext = pathinfo($file,PATHINFO_EXTENSION);
								$extention = get_FileType($ext);
							$filesArray[$count]['category'] = $extention;
							clearstatcache();
							$ss = stat($path . $file);
							$filesArray[$count]['date'] = date('c',$ss['mtime']);
							$filesArray[$count]['size'] = $ss['size'];
						}

					}
					$count++;
				}
			}
			$filesArray = subval_sort($filesArray, 'name');
			$filesArray = subval_sort($filesArray, 'type');
			$wrapper = ['status' => 'success', 'message' => 'all_files_read ok', 'response' => $filesArray];
			return json_encode($wrapper);
		}
	}

} // end of class
?>
