<?php

session_start();

$captchastring = '1234567890';
$captchastring = substr(str_shuffle($captchastring), 0, 5);

$_SESSION['cap'] = $captchastring;

$image = imagecreatefrompng('images/captchabg.png');
$colour = imagecolorallocate($image, 130, 130, 130);
$font = 'fonts/smb2.ttf';
$rotate = rand(-7, 7);
imagettftext($image, 18, $rotate, 10, 35, $colour, $font, $captchastring);
header('Content-type: image/png');
imagepng($image);