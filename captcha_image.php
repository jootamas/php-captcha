<?php
session_start();
header("Content-type: image/jpeg");
/* parameters */
$width = $_SESSION['captcha_width'];
$height = $_SESSION['captcha_height'];
$background_color = explode(',', ($_SESSION['captcha_bg_color'] ? $_SESSION['captcha_bg_color'] : '255,255,255'));
$border_color = explode(',', $_SESSION['captcha_border_color']);
$font_color = explode(',', ($_SESSION['captcha_font_color'] ? $_SESSION['captcha_font_color'] : '0,0,0'));
$font_size = $_SESSION['captcha_font_size'];
$str_length = ($_SESSION['captcha_str_length'] ? $_SESSION['captcha_str_length'] : 5);
$font_width = $_SESSION['captcha_font_width'];
$shadow_color = explode(',', $_SESSION['captcha_shadow_color']);
$shadow_distance = $_SESSION['captcha_shadow_distance'];
$line_count = $_SESSION['captcha_line_count'];
$line_color = explode(',', $_SESSION['captcha_line_color']);
$rotate_limit = $_SESSION['captcha_rotate_limit'];
$ttf = $_SESSION['captcha_ttf'];
$vertical_push = $_SESSION['captcha_vertical_push'];
$prefix = $_SESSION['captcha_prefix'];
/* */
if(!$str_length){ $str_length = 5; }
$left_padding = intval((($width-($str_length*$font_width))/2));
$top_padding = intval((($height-$font_size)/2)+$font_size);
/* create image */
$im = imagecreatetruecolor($width, $height);
$background = imagecolorallocate($im, $background_color[0], $background_color[1], $background_color[2]);
$font = imagecolorallocate($im, $font_color[0], $font_color[1], $font_color[2]);
imagefill($im, 0, 0, $background);
/* draw borders */
if(count($border_color) == 3){
 $border = imagecolorallocate($im, $border_color[0], $border_color[1], $border_color[2]);
 imageline($im, 0, 0, ($width-1), 0, $border);
 imageline($im, 0, ($height-1), ($width-1), ($height-1), $border);
 imageline($im, ($width-1), 0, ($width-1), ($height-1), $border);
 imageline($im, 0, 0, 0, ($height-1), $border);
}
/* draw random lines */
if($line_count > 0 && count($line_color) == 3){
 $line = imagecolorallocate($im, $line_color[0], $line_color[1], $line_color[2]);
 for($i=0;$i<$line_count;$i++){
  imageline($im, rand(5, ($width-5)), rand(5, ($height-5)), rand(5, ($width-5)), rand(5, ($height-5)), $line);
 }
}
/* get random letters */
$chars = 'abcdefhjknpqrstuvxy2345789'; // exclude same letters: o / 0, i / l / 1 etc.
$str = '';
for($i=0;$i<$str_length;$i++){
 $rand = rand(0, strlen($chars)-1);
 $str .= $chars[$rand];
 if(isset($rotate_limit) && is_numeric($rotate_limit)){
  $rotate = rand(($rotate_limit*-1), $rotate_limit);
 } else {
  $rotate = 0;
 }
 $left_position = ($left_padding+($i*$font_width));
 if($vertical_push > 0){
  $topPosition = ($top_padding+rand(($vertical_push*-1), $vertical_push));
 } else {
  $topPosition = $top_padding;
 }
 if(isset($shadow_color)){
  if(count($shadow_color) == 3){
   $shadow = imagecolorallocate($im, $shadow_color[0], $shadow_color[1], $shadow_color[2]);
   imagettftext($im, $font_size, $rotate, ($left_position+$shadow_distance), ($topPosition+$shadow_distance), $shadow, $ttf, $chars[$rand]);
  }
 }
 imagettftext($im, $font_size, $rotate, $left_position, $topPosition, $font, $ttf, $chars[$rand]);
}
/* save md5 hash of random string */
if(isset($prefix)){
 $_SESSION[$prefix.'_captcha'] = md5($str);
} else {
 $_SESSION['captcha'] = md5($str);
}
imagejpeg($im, null, 100);
imagedestroy($im);
?>
