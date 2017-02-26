<?php
require "start.php";
header("Content-Type: application/json");
$res = mysqli_query($db, "SELECT url, addded, id FROM urls ORDER BY addded DESC");
$array = [];
$i = 0;

while ($row = mysqli_fetch_assoc($res)) {
	$array[$i] = $row;
	$array[$i]["sort"] = $i;
	if ($_GET["m"] == 1) {
		$array[$i]["image"] = BASEURL."api/screenshot/screenshot.php?url=".urlencode($array[$i]["url"])."&w=1000&h=600&cliph=600&clipw=1000";

		if (0 !== strpos($array[$i]["url"], 'http://') && 0 !== strpos($array[$i]["url"], 'https://')) {
			$array[$i]["url"] = "http://".$array[$i]["url"];
		}
		if (file_exists("title/cache/".sha1($array[$i]["url"]))) {
			$array[$i]["title"] = trim(file_get_contents("title/cache/".sha1($array[$i]["url"])));
		}
		else {
			$data = file_get_contents($array[$i]["url"]);
			$url = explode("<title>", utf8_encode($data));
			$str = explode("</title>", $url[1])[0];
			$array[$i]["title"] = trim(utf8_decode($str));

			$handle = fopen("title/cache/".sha1($array[$i]["url"]), "w");
			fwrite($handle, trim(utf8_decode($str)));
			fclose($handle);
		}
	}
	$i++;
}

if ($_GET["m"] == 1) {
	foreach (new DirectoryIterator("title/cache") as $fileInfo) {
	    if ($fileInfo->isDot()) {
	    	continue;
	    }
	    if (time() - $fileInfo->getCTime() >= 7*24*60*60) {
	        unlink($fileInfo->getRealPath());
	    }
	}
}

echo json_encode($array);
?>
