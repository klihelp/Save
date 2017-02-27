<?php
require "start.php";
mysqli_query($db, "INSERT INTO urls (url) VALUES ('".mysqli_real_escape_string($db, $_GET["url"])."')");

$res = mysqli_query($db, "SELECT url, addded, id FROM urls WHERE id = ".mysqli_insert_id($db));
$array = [];
while ($row = mysqli_fetch_assoc($res)) {
	$array = $row;
	if ($_GET["m"] == 1) {
		$array["image"] = BASEURL."api/screenshot/screenshot.php?url=".urlencode($array["url"])."&w=1000&h=600&cliph=600&clipw=1000";

		if (0 !== strpos($array["url"], 'http://') && 0 !== strpos($array["url"], 'https://')) {
			$array["url"] = "http://".$array["url"];
		}
		if (file_exists("title/cache/".sha1($array["url"]))) {
			$array["title"] = trim(file_get_contents("title/cache/".sha1($array["url"])));
		}
		else {
			$data = file_get_contents($array["url"]);
			$url = explode("<title>", utf8_encode($data));
			$str = explode("</title>", $url[1])[0];
			$array["title"] = trim(utf8_decode($str));

			$handle = fopen("title/cache/".sha1($array["url"]), "w");
			fwrite($handle, trim(utf8_decode($str)));
			fclose($handle);
		}
	}
}
header("Content-Type: application/json");
echo json_encode($array);
?>
