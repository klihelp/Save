<?php
error_reporting(0);
session_start();

if (file_exists("../config.php")) {
	include("../config.php");
}
else {
	include("../../config.php");
}

if (isset($_GET["pass"])) {
	$_SESSION["pass"] = $_GET["pass"];
}

if (sha1($_SESSION["pass"]) != SAVE_PASS) {
	die("403 Not authorized");
}
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB) or die("Can't connect to database.");
?>
