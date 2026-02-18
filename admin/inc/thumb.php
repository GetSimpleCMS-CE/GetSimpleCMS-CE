<?php
include('common.php');
login_cookie_check();

/**
 * Thumbnail Image Generator
 *
 * REQUIREMENTS:
 * - PHP 7.4+ and GD 2.0 or later
 * - Supports GIF, JPEG, PNG, and WEBP formats
 *
 * Parameters:
 * - src - path to source image (relative to uploads folder)
 * - dest - path to thumb (where to save it, relative to thumbs folder)
 * - x - max width (default: 65)
 * - y - max height (default: 130)
 * - q - quality (1 to 100, 100 = best, default: 65)
 * - t - thumb type: -1 = same as source, 1 = GIF, 2 = JPG, 3 = PNG, 18 = WEBP
 * - f - save to file: 1 = save, 0 = output to browser (default: 1)
 *
 * Sample usage: 
 * 1. Save thumb on server: 
 *    thumb.php?src=test.jpg&dest=thumb.jpg&x=100&y=50
 * 2. Output thumb to browser:
 *    thumb.php?src=test.jpg&x=50&y=50&f=0
 *
 * @package GetSimple
 * @subpackage Images
 * @version 2.0
 */ 

// Below are default values (if parameter is not passed)

// Save to file (true) or output to browser (false)
$save_to_file = true;

// Quality for JPEG, PNG, and WEBP
// 0 (worst quality, smaller file) to 100 (best quality, bigger file)
$image_quality = 75;

// Resulting image type (1 = GIF, 2 = JPG, 3 = PNG, 18 = WEBP)
// Set to -1 to determine automatically from source
$image_type = -1;

// Maximum thumb dimensions
$max_x = 100;
$max_y = 150;

// Cut image before resizing. Set to 0 to skip this.
$cut_x = 0;
$cut_y = 0;

// Folder where source images are stored
$images_folder = GSDATAUPLOADPATH;

// Folder to save thumbnails
$thumbs_folder = GSTHUMBNAILPATH;


///////////////////////////////////////////////////
/////////////// DO NOT EDIT BELOW
///////////////////////////////////////////////////

$to_name = '';

// Parse input parameters
if (isset($_REQUEST['f'])) {
  $save_to_file = (int)$_REQUEST['f'] === 1;
}

if (isset($_REQUEST['src'])) {
  // Remove any path traversal attempts and decode
  $from_name = str_replace(['../', '..\\'], '', $_REQUEST['src']);
} else {
  die('Source file name must be specified.');
}

if (isset($_REQUEST['dest'])) {
  // Remove any path traversal attempts and decode
  $to_name = str_replace(['../', '..\\'], '', $_REQUEST['dest']);
} else if ($save_to_file) {
  die('Thumbnail file name must be specified.');
}

if (isset($_REQUEST['q'])) {
  $image_quality = max(0, min(100, (int)$_REQUEST['q'])); // Clamp between 0-100
}

if (isset($_REQUEST['t'])) {
  $image_type = (int)$_REQUEST['t'];
}

if (isset($_REQUEST['x'])) {
  $max_x = max(1, (int)$_REQUEST['x']); // At least 1 pixel
}

if (isset($_REQUEST['y'])) {
  $max_y = max(1, (int)$_REQUEST['y']); // At least 1 pixel
}

$path_parts = pathinfo($from_name);

// Path traversal protection
if (!filepath_is_safe(GSDATAUPLOADPATH . $from_name, GSDATAUPLOADPATH, true)) {
  die('Invalid source image path');
}
if (!path_is_safe(GSTHUMBNAILPATH . dirname($to_name), GSTHUMBNAILPATH, true)) {
  die('Invalid destination image path');
}

// Check if folders exist
if (!file_exists($images_folder)) {
  die('Images folder does not exist (update $images_folder in the script)');
}
if ($save_to_file && !file_exists($thumbs_folder)) {
  die('Thumbnails folder does not exist (update $thumbs_folder in the script)');
}

// Create subdirectories if needed
if ($save_to_file && !empty($path_parts['dirname']) && $path_parts['dirname'] !== '.') {
  $dirs = explode('/', $path_parts['dirname']);
  $folder = $thumbs_folder;
  
  foreach ($dirs as $dir) {
    if (empty($dir) || $dir === '.') {
      continue;
    }
    
    $folder .= DIRECTORY_SEPARATOR . $dir;
    
    if (!is_dir($folder)) {
      if (!mkdir($folder, 0755, true)) {
        die('Failed to create thumbnail directory: ' . htmlspecialchars($folder));
      }
    }
  }
}

// Allocate sufficient memory for image processing
// Increase if processing very large images
ini_set('memory_limit', '256M');

// Include image processing class
include('image.class.php');

// Create thumbnail generator instance
$img = new Zubrag_image();

// Initialize settings
$img->max_x        = $max_x;
$img->max_y        = $max_y;
$img->cut_x        = $cut_x;
$img->cut_y        = $cut_y;
$img->quality      = $image_quality;
$img->save_to_file = $save_to_file;
$img->image_type   = $image_type;

// Generate thumbnail
try {
  $img->GenerateThumbFile($images_folder . $from_name, $thumbs_folder . $to_name);
} catch (Exception $e) {
  die('Thumbnail generation failed: ' . htmlspecialchars($e->getMessage()));
}