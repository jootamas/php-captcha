## Fully customizable captcha in PHP

## Usage

1. add captcha_class.php and captcha_image.php to your system
2. search and upload any TTF font
3. set $url (URL of captcha image) and $ttf (path of TTF font) in Captcha class
4. set captcha parameters as you wish, based on your site design

Get captcha:

```php
$captcha = new Captcha();

/* Optional: overwrite default parameters */
$captcha->reconfigure('str_length', '4');
```

Form:

```php
<form method="post">
...
<img src="<?php echo $captcha->get('PREFIX'); ?>" />
...
<input type="text" name="captcha_input" maxlength="4" />
</form>
```

*PREFIX: If do you use captcha on more pages, you can set prefix, e.g. contact, cart, etc.*

Validate:

```php
if($captcha->check('PREFIX', $_POST['captcha_input'])){
	/* success, do something */
} else {
	/* error, do something */
}
```

*Note 1: session_start() required!*

*Note 2: minimum PHP version: 4.0.6*

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

(font: https://fonts.google.com/specimen/Titillium+Web)

-----

*All suggestions will be welcome. :)*
