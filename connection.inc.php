<?php
session_start();
$con=mysqli_connect("localhost","root","","onlinestore");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/onlinestore/');
define('SITE_PATH','http://127.0.0.1/onlinestore/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');

define('PRODUCT_MULTIPLE_IMAGE_SERVER_PATH',SERVER_PATH.'media/product_images/');
define('PRODUCT_MULTIPLE_IMAGE_SITE_PATH',SITE_PATH.'media/product_images/');
?>

