## Full customizable captcha in PHP

## Usage

1. add captcha.class.php to your system
2. search any font in TTF or OTF, and set it in the Captcha class
3. set captcha parameters as you wish, based on your site design

Quick example:

```php
<?php
session_start();
include('captcha.class.php');

define(CAPTCHA_TTF, './myfont.ttf');

$captcha = new Captcha();

/* Optional: overwrite default parameters */
$captcha->str_length = 4;

if($_POST){
 if($captcha->check($_POST['captcha_input'])){
  /* success, do something */
 } else {
  /* error, do something */
 }
}
?>
<form method="post">
<input type="text" name="name" />
<input type="text" name="email" />
<textarea name="message"></textarea>
...
<img src="<?php echo $captcha->get(); ?>" />
...
<input type="text" name="captcha_input" maxlength="4" />
</form>
```

*PREFIX: If you use more captcha on one page, you can set prefix, e.g. contact, cart, etc.*

## Examples

Basic:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-1.jpg)

Shadows:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-2.jpg)

Push letters vertically up or down:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-3.jpg)

Rotate letters:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-4.jpg)

Draw random lines on the background:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-5.jpg)

And any sizes:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-6.jpg)

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-7.jpg)

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-8.jpg)

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-9.jpg)

Patterns:

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-10.jpg)

![Picture](http://demo.jootamas.eu/php-captcha/php-captcha-example-11.jpg)

## Changelog

### 18/12/2016 - v1.0

init

### 04/09/2017 - v2.0

- some fixes
- simplification: remove captcha_image.php, the captcha image generated in the Captcha class
- use pattern
- replace the attributes of check() function

### 26/10/2017 - v2.1

- quick fix at patterns
- error handling: if don't set font file print error message and exit
- remove reconfigure() function, because it's unnecessary

## Notes

*Note 1: session_start() required!*

*Note 2: minimum PHP version: 4.0.6*

*Font: https://fonts.google.com/specimen/Titillium+Web*

*Patterns: http://bgrepeat.com*

-----

*All suggestions will be welcome. :)*
