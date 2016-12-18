<?php
class Captcha {
 /**
  * URL of captcha image PHP in your system (e.g. http://example.com/captcha_image.php)
  * @var string
  */
 private $url = '';
 /**
  * TTF file of font (e.g. /var/www/example.com/assets/fonts/font.ttf)
  * @var string
  */
 private $ttf = '';
 /**
  * Width of captcha image in pixels
  * @var int
  */
 private $width = 300;
 /**
  * Height of captcha image in pixels
  * @var int
  */
 private $height = 100;
 /**
  * Background color in RGB, comma separated, default is white (255, 255, 255)
  * @var string
  */
 private $bg_color = '200,200,200';
 /**
  * Border color in RGB, comma separated, leave blank to disable border
  * @var string
  */
 private $border_color = '255,0,0';
 /**
  * Font color in RGB, comma separated, default is black (0, 0, 0)
  * @var string
  */
 private $font_color = '0,0,0';
 /**
  * Font size
  * @var int
  */
 private $font_size = 30;
 /**
  * Length of string, default is 5
  * @var int
  */
 private $str_length = 5;
 /**
  * Width of fonts, increase it for bigger letter space. If you leave blank, then $font_width will equal to $font_size
  * @var int
  */
 private $font_width = 32;
 /**
  * Color of text shadow effect in RGB, comma separated, leave blank to disable shadow
  * @var string
  */
 private $shadow_color = '128,128,128';
 /**
  * Shadow distance from text in pixels
  * @var int
  */
 private $shadow_distance = 5;
 /**
  * Draw random lines, set 0 to disable lines
  * @var int
  */
 private $line_count = 50;
 /**
  * Color of random lines in RGB, comma separated
  * @var string
  */
 private $line_color = '0,255,0';
 /**
  * Rotate letters, set 0 to disable. If you set 10, then will generate random between -10 (left) and 10 (right)
  * @var int
  */
 private $rotate_limit = 20;
 /**
  * Push letters up or down from center of image, set 0 to disable. If you set 10, then will generate random between -10 (up) and 10 (down)
  * @var int
  */
 private $vertical_push = 12;
 /**
  * Overwrite default parameters
  * @param string Name of variable
  * @param string New value
  * @return void
  */
 public function reconfigure($key, $value){
  $this->$key = $value;
 }
 /**
  * Get captcha image
  * @param string If do you use captcha on more page, you can set prefix, e.g. contact, cart, etc.
  * @return string URL of captcha image PHP
  */
 public function get($prefix){
  $_SESSION['captcha_width'] = $this->width;
  $_SESSION['captcha_height'] = $this->height;
  $_SESSION['captcha_bg_color'] = $this->bg_color;
  $_SESSION['captcha_border_color'] = $this->border_color;
  $_SESSION['captcha_font_color'] = $this->font_color;
  $_SESSION['captcha_font_size'] = $this->font_size;
  $_SESSION['captcha_str_length'] = $this->str_length;
  $_SESSION['captcha_font_width'] = $this->font_width;
  $_SESSION['captcha_shadow_color'] = $this->shadow_color;
  $_SESSION['captcha_shadow_distance'] = $this->shadow_distance;
  $_SESSION['captcha_line_count'] = $this->line_count;
  $_SESSION['captcha_line_color'] = $this->line_color;
  $_SESSION['captcha_rotate_limit'] = $this->rotate_limit;
  $_SESSION['captcha_ttf'] = $this->ttf;
  $_SESSION['captcha_vertical_push'] = $this->vertical_push;
  $_SESSION['captcha_prefix'] = $prefix;
  return $this->url;
 }
 /**
  * Validate user input
  * @param string Captcha prefix
  * @param string Captcha input from HTML form (e.g. $_POST['captcha_input'])
  * @return bool true|false
  */
 public function check($prefix, $string){
  if(strlen($string) != $this->str_length){
   return false;
  }
  if($prefix != '' && md5($string) == $_SESSION[$prefix.'_captcha']){
   return true;
  } else if($prefix == '' && md5($string) == $_SESSION['captcha']){
   return true;
  } else {
   return false;
  }
 }
}
?>
