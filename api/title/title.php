<?php
require "../start.php";
error_reporting(E_ALL);
$data = file_get_contents($_GET["url"]);
$url = explode("<title>", utf8_encode($data));
$str = explode("</title>", $url[1])[0];
echo utf8_decode($str);
?>