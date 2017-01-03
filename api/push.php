<?php
require "start.php";
mysqli_query($db, "INSERT INTO urls (url) VALUES ('".mysqli_real_escape_string($db, $_GET["url"])."')");

$res = mysqli_query($db, "SELECT url, addded, id FROM urls WHERE id = ".mysqli_insert_id($db));
$array = [];
while ($row = mysqli_fetch_assoc($res)) {
	$array = $row;
}

if ($_GET["b"] == 1) {
	echo '<script>window.history.back();</script>';
}
else {
	header("Content-Type: application/json");
	echo json_encode($array);
}
?>