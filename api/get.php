<?php
require "start.php";
header("Content-Type: application/json");
$res = mysqli_query($db, "SELECT url, addded, id FROM urls ORDER BY addded DESC");
$array = [];
$i = 0;
while ($row = mysqli_fetch_assoc($res)) {
	$array[$i] = $row;
	$array[$i]["sort"] = $i;
	$i++;
}
echo json_encode($array);
?>