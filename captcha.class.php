<?php
class Captcha {
 /**
  * TTF or OTF file of font (e.g. /var/www/example.com/assets/fonts/font.ttf)
  * @var string
  */
 private $ttf = '';
 /**
  * Pattern image (e.g. /var/www/example.com/images/pattern.png)
  * @var string
  */
 private $pattern = '';
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
 private $border_color = '0,0,0';
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
 private $font_width = 40;
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
 private $line_count = 0;
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
  * Push letters vertical up or down from center of image, set 0 to disable. If you set 10, then will generate random between -10 (up) and 10 (down)
  * @var int
  */
 private $vertical_push = 12;
 /**
  * Overwrite default parameters
  * @param  string  Name of variable
  * @param  string  New value
  * @return void
  */
 public function reconfigure($key, $value){
  $this->$key = $value;
 }
 /**
  * Get captcha image
  * @param  string  If you use captcha on more page, you can set prefix, e.g. contact, cart, etc.
  * @return string  captcha image
  */
 public function get($prefix = ''){
  $background_color = explode(',', ($this->bg_color ? $this->bg_color : '255,255,255'));
  if($this->border_color != ''){
   $border_color = explode(',', $this->border_color);
  }
  $font_color = explode(',', ($this->font_color ? $this->font_color : '0,0,0'));
  $str_length = ($this->str_length ? $this->str_length : 5);
  $font_width = ($this->font_width != '' ? $this->font_width : $this->font_size);
  $shadow_color = explode(',', $this->shadow_color);
  $line_color = explode(',', $this->line_color);
  $left_padding = intval((($this->width-($str_length*$font_width))/2));
  $top_padding = intval((($this->height-$this->font_size)/2)+$this->font_size);
  /* create image */
  $im = imagecreatetruecolor($this->width, $this->height);
  /* pattern or background color */
  if($this->pattern != ''){
   $pattern = imagecreatefrompng($this->pattern);
   imagecopy($im, $pattern, 0, 0, 0, 0, $this->width, $this->height);
  } else {
   $background = imagecolorallocate($im, $background_color[0], $background_color[1], $background_color[2]);
   imagefill($im, 0, 0, $background);
  }
  $font = imagecolorallocate($im, $font_color[0], $font_color[1], $font_color[2]);
  /* draw borders */
  if(count($border_color) == 3){
   $border = imagecolorallocate($im, $border_color[0], $border_color[1], $border_color[2]);
   imageline($im, 0, 0, ($this->width-1), 0, $border);
   imageline($im, 0, ($this->height-1), ($this->width-1), ($this->height-1), $border);
   imageline($im, ($this->width-1), 0, ($this->width-1), ($this->height-1), $border);
   imageline($im, 0, 0, 0, ($this->height-1), $border);
  }
  /* draw random lines */
  if($this->line_count > 0 && count($line_color) == 3){
   $line = imagecolorallocate($im, $line_color[0], $line_color[1], $line_color[2]);
   for($i=0;$i<$this->line_count;$i++){
    imageline($im, rand(5, ($this->width-5)), rand(5, ($this->height-5)), rand(5, ($this->width-5)), rand(5, ($this->height-5)), $line);
   }
  }
  /* get random letters */
  $chars = 'abcdefhjknpqrstuvxy2345789'; // exclude same letters: o / 0, i / l / 1 etc.
  $str = '';
  for($i=0;$i<$str_length;$i++){
   $rand = rand(0, strlen($chars)-1);
   $str .= $chars[$rand];
   if(isset($this->rotate_limit) && is_numeric($this->rotate_limit)){
    $rotate = rand(($this->rotate_limit*-1), $this->rotate_limit);
   } else {
    $rotate = 0;
   }
   $left_position = ($left_padding+($i*$font_width));
   if($this->vertical_push > 0){
    $topPosition = ($top_padding+rand(($this->vertical_push*-1), $this->vertical_push));
   } else {
    $topPosition = $top_padding;
   }
   if(isset($shadow_color)){
    if(count($shadow_color) == 3){
     $shadow = imagecolorallocate($im, $shadow_color[0], $shadow_color[1], $shadow_color[2]);
     imagettftext($im, $this->font_size, $rotate, ($left_position+$this->shadow_distance), ($topPosition+$this->shadow_distance), $shadow, $this->ttf, $chars[$rand]);
    }
   }
   imagettftext($im, $this->font_size, $rotate, $left_position, $topPosition, $font, $this->ttf, $chars[$rand]);
  }
  /* save md5 hash of random string */
  if($prefix != ''){
   $_SESSION[$prefix.'_captcha'] = md5($str);
  } else {
   $_SESSION['captcha'] = md5($str);
  }
  ob_start();
  imagejpeg($im, null, 100);
  $imageBase64 = ob_get_clean();
  imagedestroy($im);
  return 'data:image/jpeg;base64,'.base64_encode($imageBase64);
 }
 /**
  * Validate user input
  * @param  string  Captcha prefix
  * @param  string  Captcha input from HTML form (e.g. $_POST['captcha_input'])
  * @return bool    true|false
  */
 public function check($string, $prefix = ''){
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
