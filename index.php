<?php include_once("functions.php");
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<title>Турагентство</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<header>

			</header>
		</div>
		<div class="row">
			<?php
			include_once("pages/menu.php");
			?>
		</div>
		<div class="row">
			<section class="col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
				<?php
				if(isset($_GET['page'])) {$page=$_GET['page'];
				if($page=="main") {include_once("pages/main.php");}
				if($page=="searchtour") {include_once("pages/searchtour.php");}
				if($page=="hottour") {include_once("pages/hottour.php");}
				if($page=="admin"){include_once("pages/admin.php");}
				if($page=="login"){include_once("pages/login.php");}
				if($page=="register"){include_once("pages/register.php");}
				if($page=="logout") {
					session_destroy();
					echo "<script>window.location.href='/'</script>";
				}
			}
			?>
		</section>
	</div>
	<div class="row">
		<footer>

		</footer>
	</div>
</div>





<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>