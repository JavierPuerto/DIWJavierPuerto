<?php

session_start();

$texto = md5(uniqid());
$texto = substr($texto, 0, 6);

$_SESSION['captcha_code'] = $texto;

$img_captcha = imagecreatefromjpeg("../assets/images/captcha.jpg");

if ($img_captcha === false) {
    die("No se pudo cargar la imagen de fondo.");
}

$colorTexto1= imagecolorallocate($img_captcha, 175, 175, 175);
$colorTexto2= imagecolorallocate($img_captcha, 125, 125, 125);

imagestring($img_captcha, 5, 35, 14, $texto, $colorTexto1);
imagestring($img_captcha, 5, 33, 12, $texto, $colorTexto2);

header("Content-type: image/jpeg");

imagejpeg($img_captcha);

?>
