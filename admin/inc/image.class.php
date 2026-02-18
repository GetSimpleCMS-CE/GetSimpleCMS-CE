<?php
/**
 * Thumbnail Class for Image Generator
 * 
 * Modernized for PHP 7.4-8.5 compatibility
 *
 * @package GetSimple
 * @subpackage Images
 * @version 2.0
 */ 

class Zubrag_image {

  public bool $save_to_file = true;
  public int $image_type = -1;
  public int $quality = 100;
  public int $max_x = 100;
  public int $max_y = 100;
  public int $cut_x = 0;
  public int $cut_y = 0;
 
  /**
   * Save image to file or output to browser
   * 
   * @param \GdImage $im Image resource
   * @param string $filename Output filename
   * @return bool Success status
   */
  public function SaveImage($im, string $filename): bool {
    $res = false;
 
    // ImageGIF is not included into some GD2 releases, so it might not work
    // output png if gifs are not supported
    if(($this->image_type == 1) && !function_exists('imagegif')) {
      $this->image_type = 3;
    }

    // Set appropriate header
    $this->setContentTypeHeader($this->image_type);

    switch ($this->image_type) {
      case 1: // GIF
        if ($this->save_to_file) {
          $res = imagegif($im, $filename);
        } else {
          $res = imagegif($im, null);
        }
        break;
        
      case 2: // JPEG
        if ($this->save_to_file) {
          $res = imagejpeg($im, $filename, $this->quality);
        } else {
          $res = imagejpeg($im, null, $this->quality);
        }
        break;
        
      case 3: // PNG
        // Convert to PNG quality (0-9 scale, inverted)
        $pngQuality = 9 - min(round($this->quality / 10), 9);
        if ($this->save_to_file) {
          $res = imagepng($im, $filename, $pngQuality);
        } else {
          $res = imagepng($im, null, $pngQuality);
        }
        break;
        
      case 18: // WEBP
        if ($this->save_to_file) {
          $res = imagewebp($im, $filename, $this->quality);
        } else {
          $res = imagewebp($im, null, $this->quality);
        }
        break;
    }
 
    return $res;
  }
 
  /**
   * Set HTTP Content-Type header based on image type
   * 
   * @param int $type Image type constant
   */
  private function setContentTypeHeader(int $type): void {
    $headers = [
      1 => 'image/gif',
      2 => 'image/jpeg',
      3 => 'image/png',
      18 => 'image/webp'
    ];
    
    if (isset($headers[$type])) {
      header('Content-type: ' . $headers[$type]);
    }
  }
 
  /**
   * Create image resource from file based on type
   * 
   * @param int $type Image type (1=GIF, 2=JPEG, 3=PNG, 18=WEBP)
   * @param string $filename Source image path
   * @return \GdImage|false Image resource or false on failure
   */
  public function ImageCreateFromType(int $type, string $filename) {
    $im = false;
    
    switch ($type) {
      case 1:
        $im = imagecreatefromgif($filename);
        break;
      case 2:
        $im = imagecreatefromjpeg($filename);
        break;
      case 3:
        $im = imagecreatefrompng($filename);
        break;
      case 18:
        $im = imagecreatefromwebp($filename);
        break;
    }
    
    return $im;
  }
 
  /**
   * Generate thumbnail from image and save it
   * 
   * @param string $from_name Source image path
   * @param string $to_name Destination thumbnail path
   * @return void
   */
  public function GenerateThumbFile(string $from_name, string $to_name): void {
    // Validate filenames
    if (!validImageFilename($from_name)) {
      die('invalid src filetype');
    }
    if (!validImageFilename($to_name)) {
      die('invalid dest filetype');
    }

    // Security: Block HTTP/HTTPS downloads (remove this feature for security)
    if (preg_match('/^https?:\/\//i', $from_name)) {
      die('Remote image URLs are not allowed for security reasons');
    }

    // Check if source file exists
    if (!file_exists($from_name)) {
      die('Source image does not exist!');
    }
    
    // Get source image size (width/height/type)
    // orig_img_type: 1=GIF, 2=JPG, 3=PNG, 18=WEBP
    $imageInfo = getimagesize($from_name);
    if ($imageInfo === false) {
      die('Cannot get image information');
    }
    
    [$orig_x, $orig_y, $orig_img_type] = $imageInfo;

    // Cut image if specified by user
    if ($this->cut_x > 0) {
      $orig_x = min($this->cut_x, $orig_x);
    }
    if ($this->cut_y > 0) {
      $orig_y = min($this->cut_y, $orig_y);
    }
 
    // Should we override thumb image type?
    $this->image_type = ($this->image_type != -1 ? $this->image_type : $orig_img_type);
 
    // Check for allowed image types
    if ($orig_img_type !== 18 && ($orig_img_type < 1 || $orig_img_type > 3)) {
      die('Image type not supported');
    }
 
    // Calculate new dimensions
    if ($orig_x > $this->max_x || $orig_y > $this->max_y) {
      // Resize while maintaining aspect ratio
      $per_x = $orig_x / $this->max_x;
      $per_y = $orig_y / $this->max_y;
      
      if ($per_y > $per_x) {
        $this->max_x = (int)($orig_x / $per_y);
      } else {
        $this->max_y = (int)($orig_y / $per_x);
      }
    } else {
      // Image is smaller than max dimensions - just copy
      if ($this->save_to_file) {
        if (!copy($from_name, $to_name)) {
          die('Failed to copy image file');
        }
      } else {
        $this->setContentTypeHeader($this->image_type);
        readfile($from_name);
      }
      return;
    }
 
    // Create new image canvas
    if ($this->image_type == 1) {
      // Use imagecreate for GIFs (palette images)
      $ni = imagecreate($this->max_x, $this->max_y);
    } else {
      // Create a new true color image
      $ni = imagecreatetruecolor($this->max_x, $this->max_y);
    }
    
    if ($ni === false) {
      die('Failed to create new image');
    }
 
    // Handle transparency for PNG and GIF
    if ($this->image_type == 3) {
      // PNG transparency
      imagealphablending($ni, false);
      imagesavealpha($ni, true);
      $transparent = imagecolorallocatealpha($ni, 255, 255, 255, 127);
      imagefilledrectangle($ni, 0, 0, $this->max_x, $this->max_y, $transparent);
    } elseif ($this->image_type == 1) {
      // GIF transparency
      $white = imagecolorallocate($ni, 255, 255, 255);
      imagefilledrectangle($ni, 0, 0, $this->max_x, $this->max_y, $white);
    } else {
      // Fill with white background for JPEG/WEBP
      $white = imagecolorallocate($ni, 255, 255, 255);
      imagefilledrectangle($ni, 0, 0, $this->max_x, $this->max_y, $white);
    }
    
    // Create image from source file
    $im = $this->ImageCreateFromType($orig_img_type, $from_name);
    
    if ($im === false) {
      imagedestroy($ni);
      die('Failed to load source image');
    }
    
    // Copy the palette from one image to another (for GIFs)
    if ($this->image_type == 1) {
      imagepalettecopy($ni, $im);
    }
    
    // Copy and resize with resampling for better quality
    imagecopyresampled(
      $ni, $im,                         // destination, source
      0, 0, 0, 0,                       // dstX, dstY, srcX, srcY
      $this->max_x, $this->max_y,       // dstW, dstH
      $orig_x, $orig_y                  // srcW, srcH
    );
 
    // Save thumbnail
    $this->SaveImage($ni, $to_name);

    // Clean up resources
    imagedestroy($im);
    imagedestroy($ni);
  }
}