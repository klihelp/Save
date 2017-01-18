<?php
	session_start();
	error_reporting(0);
	if (!file_exists("config.php")) {
		header("Location: install.php");
		exit;
	}
	require "config.php";

	if (isset($_POST["pass"])) {
		if (sha1($_POST["pass"]) == SAVE_PASS) {
			$_SESSION["pass"] = $_POST["pass"];
			die("ok");
		}
		else {
			die("error");
		}
	}

	if (sha1($_SESSION["pass"]) != SAVE_PASS) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Save</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" id="theme-style">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<link rel="icon" type="image/png" href="assets/icon.png">
		<meta name="theme-color" content="#2C3E50">
	</head>
	<body class="login">
		<div class="container text-center">
			<div class="inner">
				<h1>Save</h1>
				<form onsubmit="return app.login();">
					<div class="input-group has-feedback">
						<input type="password" id="pass" placeholder="Password" class="form-control" autofocus>
						<span class="input-group-btn">
							<a href="#!" onclick="app.login()" class="btn btn-default">Login</a>
						</span>
					</div>
				</form>
			</div>
		</div>

		<div class="overlay"></div>
		<div class="overlay2"></div>

		<script type="text/javascript">
			$(document).ready(function(){
				$("body").fadeIn();
			});

			var app = {};

			app.login = function () {
				$(".overlay").fadeIn();
				$("body").addClass("loading");

				$.ajax({
					url: "index.php",
					type: "POST",
					data: "pass=" + encodeURIComponent($("#pass").val())
				}).done(function(res){
					setTimeout(function(){
						if (res == "ok") {
							$(".overlay2").fadeIn(function(){
								window.location.reload();
							});
						}
						else {
							$(".overlay").fadeOut();
							$("body").removeClass("loading");
							$(".has-feedback").addClass("has-error").addClass("shake");
							setTimeout(function(){
								$(".has-feedback").removeClass("shake").removeClass("has-error");
							}, 1000);
						}
					}, 1000);
				});
				return false;
			};
		</script>
	</body>
</html>
<?php
		exit;
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Save</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/animate.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/lazyload.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<link rel="icon" type="image/png" href="assets/icon.png">
		<meta charset="utf-8">
		<meta name="theme-color" content="#2C3E50">
	</head>
	<body>
		<div class="navbar navbar-default" role="navigation">
	        <div class="navbar-header">
	        	<a class="navbar-brand" href="#">Save</a>
	            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
	            </button>
	        </div>
	        <div class="collapse navbar-collapse">
	            <ul class="nav navbar-nav navbar-left">
	                <li><a href="#!">Home</a></li>
	                <li><a href="#!" onclick='$("#search").addClass("active").focus(),$(".navbar").addClass("search")'>Search</a>
	                <li><a href="javascript:var s = document.createElement('script');s.setAttribute('src','<?php echo BASEURL; ?>js/jquery.min.js');document.head.appendChild(s);var s2 = document.createElement('script');s2.setAttribute('src','<?php echo BASEURL; ?>js/add.js');document.head.appendChild(s2);" onclick="return alert('Drag and drop me into your bookmarks!');">Bookmark</a></li>
	            </ul>
	            <form class="navbar-form navbar-right" role="search" onsubmit="return app.add()">
				  <div class="form-group">
				    <input type="text" class="form-control" placeholder="Add..." autocomplete="off" id="add">
				  </div>
				</form>
	        </div>
		</div>
		<input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search">

		<div class="container">
			<div class="row panel-parent" style="display: none;">
			</div>
			<div class="row loader">
				<div class="col-lg-4 col-sm-6">
					<div class="panel-loading">
						<img src="assets/loading.svg">
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 hidden-xs">
					<div class="panel-loading">
						<img src="assets/loading.svg">
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 hidden-xs hidden-sm hidden-md">
					<div class="panel-loading">
						<img src="assets/loading.svg">
					</div>
				</div>
			</div>
			<div class="text-center no-items" style="display: none;">
				<h2>It's empty here...</h2>
				<p>Start adding links to Save!</p>
				<input type="text" class="form-control" onfocus="$('#add').focus()" placeholder="Add link..." style="max-width: 80%; display: inline-block;">
			</div>
			<div class="text-center about" data-toggle="modal" data-target="#about">
				<br><br>
				<small>About</small>
				<br><br>
			</div>
		</div>

		<div aria-hidden="true" aria-labelledby="deleteLabel" class="modal fade" id="delete" role="dialog" tabindex="-1">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="deleteLabel">Delete?</h4>
					</div>
					<div class="modal-body">
						Do you want to delete this item?
					</div>
					<div class="modal-footer">
						<a class="btn btn-danger" href="#!" target="_self" onclick="app.deleteY()" data-dismiss="modal">Delete</a>
						<a class="btn btn-default" href="#!" target="_self" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>

		<div aria-hidden="true" aria-labelledby="deleteLabel" class="modal fade" id="copy" role="dialog" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="deleteLabel">Copy</h4>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<input type="text" id="copyurl" placeholder="URL" class="form-control">
							<span class="input-group-addon">
								<a href="#!" onclick="copyToClipboard(document.getElementById('copyurl'));$(this).text('Copied!')" data-dismiss="modal">Copy</a>
							</span>
						</div>
					</div>
					<div class="modal-footer">
						<a class="btn btn-default" href="#!" target="_self" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>

		<div aria-hidden="true" aria-labelledby="themeLabel" class="modal fade" id="theme" role="dialog" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="themeLabel">Theme</h4>
					</div>
					<div class="modal-body">
						<select></select>
					</div>
					<div class="modal-footer">
						<a class="btn btn-primary" data-dismiss="modal" href="#!" target="_self" onclick="app.applyTheme()">Apply</a>
						<a class="btn btn-default" data-dismiss="modal" href="#!" target="_self">Cancel</a>
					</div>
				</div>
			</div>
		</div>

		<div aria-hidden="true" aria-labelledby="aboutLabel" class="modal fade" id="about" role="dialog" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="aboutLabel">About</h4>
					</div>
					<div class="modal-body text-center">
						<p>&copy; 2017 krmax44<br>
						v1.0.2<br>
						Released under the MIT License</p>
						
						<p><small><a href="https://github.com/krmax44/save" target="_blank">Star me on GitHub</a></small></p>
						
						<div class="btn-group btn-group-justified">
							<a href="https://twitter.com/krmax44" target="_blank" class="btn btn-info"><i class="icon-twitter"></i></a>
							<a href="https://github.com/krmax44" target="_blank" class="btn btn-default"><i class="icon-github"></i></a>
							<a href="https://google.com/+krmax44" target="_blank" class="btn btn-danger"><i class="icon-gplus"></i></a>
							<a href="https://krmax44.de" target="_blank" class="btn btn-default"><i class="icon-globe"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="js/script.js"></script>
	</body>
</html>