<?php
error_reporting(0);
if (file_exists("config.php")) {
	die("There is already an existing config file. Delete config.php to install Save again.");
}

if ($_GET["i"] == 1) {
	$db = mysqli_connect($_POST["mysqlhost"], $_POST["mysqluser"], $_POST["mysqlpass"], $_POST["mysqldb"]) or die("error");
	mysqli_query($db, 'CREATE TABLE IF NOT EXISTS `urls` (
`id` int(11) NOT NULL,
  `url` text NOT NULL,
  `addded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1');
	mysqli_query($db, 'ALTER TABLE `urls`
 ADD PRIMARY KEY (`id`)');
	mysqli_query($db, 'ALTER TABLE `urls`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22');

	$handle = fopen("config.php", "w");
	$config = '<?php
define("MYSQL_HOST", "'.$_POST["mysqlhost"].'"); 	// MySQL host
define("MYSQL_USER", "'.$_POST["mysqluser"].'"); 		// MySQL username
define("MYSQL_PASS", "'.$_POST["mysqlpass"].'");			// MySQL password
define("MYSQL_DB", "'.$_POST["mysqldb"].'");			// MySQL database
define("SAVE_PASS", "'.sha1($_POST["savepass"]).'");				// your sha-1 encrypted password
define("BASEURL", "'.$_POST["baseurl"].'");			// URL to Save, ending with "/"
?>';
	fwrite($handle, $config);
	fclose($handle);

	$handle2 = fopen("js/add.js", "w");
	fwrite($handle2, '$("body").append(\'<iframe src="'.$_POST["baseurl"].'api/push.php?url=\'+encodeURIComponent(window.location.href)+\'" style="display:none;"></iframe>\');
$("body").append(\'<div class="ns728g" style="font-family:sans-serif;position:fixed;top:5px;right:5px;padding:20px;background-color:#2c3e50;border-radius:5px;color:#fff;z-index:99999999;">Saved!</div>\');
$(".ns728g").delay(2000).fadeOut(3000);');
	fclose($handle2);

	die("ok");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Save</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<link rel="icon" type="image/png" href="assets/icon.png">
		<meta name="theme-color" content="#2C3E50">
	</head>
	<body>
		<div class="navbar navbar-default" role="navigation">
	        <div class="navbar-header">
	        	<a class="navbar-brand" href="#">Save</a>
	        </div>
		</div>

		<div class="container">
			<h1>Save Installer</h1>
			<div class="alert alert-success" style="display: none">
				Save was installed successfully! <a href="index.php" style="color: blue;">Login</a>
			</div>
			<div class="alert alert-danger" style="display: none">
				Snap! Save could not connect to the database. Please try again.
			</div>
			<form onsubmit="return app.install()">
				<input type="text" placeholder="MySQL host" name="mysqlhost" class="form-control">
				<input type="text" placeholder="MySQL user" name="mysqluser" class="form-control">
				<input type="text" placeholder="MySQL password" name="mysqlpass" class="form-control">
				<input type="text" placeholder="MySQL database" name="mysqldb" class="form-control">
				<input type="password" placeholder="Save password" name="savepass" class="form-control" id="pass">
				<p>URL to Save (ending with <code>/</code>, beginning with <code>http://</code> or <code>https://</code>):</p>
				<input type="text" placeholder="Save Base URL" name="baseurl" class="form-control" id="baseurl">
				<button onclick="app.install()" class="btn btn-primary btn-block">Install</button>
			</form>
		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				$("body").fadeIn();
				var baseurl = window.location.href.split("install.php")[0];
				$("#baseurl").val(baseurl);
			});

			var app = {
				install: function () {
					$(".alert-danger").hide();
					$("button").prop("disabled", true).text("Installing...");
					$.ajax({
						url: "install.php?i=1",
						data: $("form").serialize(),
						type: "POST"
					}).done(function(res){
						console.log(res);
						if (res == "ok") {
							$(".alert-success").show();
						}
						else {
							$(".alert-danger").show();
						}
						$("button").prop("disabled", false).text("Install");
					});
					return false;
				}
			};
		</script>
	</body>
</html>