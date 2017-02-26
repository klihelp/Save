<?php
require "../start.php";
if (0 !== strpos($_GET["url"], 'http://') && 0 !== strpos($_GET["url"], 'https://')) {
	$_GET["url"] = "http://".$_GET["url"];
}
if (file_exists("cache/".sha1($_GET["url"]))) {
	echo trim(file_get_contents("cache/".sha1($_GET["url"])));
}
else {
	$data = file_get_contents($_GET["url"]);
	$url = explode("<title>", utf8_encode($data));
	$str = explode("</title>", $url[1])[0];
	echo trim(utf8_decode($str));

	$handle = fopen("cache/".sha1($_GET["url"]), "w");
	fwrite($handle, trim(utf8_decode($str)));
	fclose($handle);
}

foreach (new DirectoryIterator("cache") as $fileInfo) {
    if ($fileInfo->isDot()) {
    	continue;
    }
    if (time() - $fileInfo->getCTime() >= 7*24*60*60) {
        unlink($fileInfo->getRealPath());
    }
}
?>
