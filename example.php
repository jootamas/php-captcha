<?php
/**
 * session_start() required!
 */
session_start();
/*
 * define font (required) and pattern (optional)
 */
define(CAPTCHA_TTF, '');
define(CAPTCHA_PATTERN, '');

include('captcha.class.php');
/**
 * Call captcha
 */
$captcha = new Captcha();
/**
 * Optional: overwrite default parameters
 */
$captcha->str_length = 4;
/**
 * Validate
 */
if($_POST){
 if($captcha->check($_POST['captcha_input'], 'contact_form')){
  /* success, do something */
  echo 'captcha OK';
  echo '<br />';
 } else {
  /* error, do something */
  echo 'captcha FAIL';
  echo '<br />';
 }
}
?>
<img src="<?php echo $captcha->get('contact_form'); ?>" />
<br />
<br />
<form method="post">
 <input type="text" name="captcha_input" maxlength="4" />
</form>

