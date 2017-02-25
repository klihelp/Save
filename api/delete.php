<?php
require "start.php";
mysqli_query($db, "DELETE FROM urls WHERE id = ".mysqli_real_escape_string($db, $_GET["url"]));
if (mysqli_affected_rows($db) == 0) {
	echo "error";
}
else {
	echo "ok";
}
?>
