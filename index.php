<?php include_once("functions.php");
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/refresh.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/styles.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
	<title>Турагентство «Mandrivka»</title>
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
			<section style='width:100%;'>
					<?php
					if($_SERVER['REQUEST_URI']=="/") {include_once("pages/main.php");} else
					if(isset($_GET['page'])) {$page=$_GET['page'];
					if($page=="searchtour") {include_once("pages/searchtour.php");} else
					if($page=="hottour") {include_once("pages/hottour.php");} else
					if($page=="admin"){include_once("pages/admin.php");} else
					if($page=="login"){include_once("pages/login.php");} else
					if($page=="register"){include_once("pages/register.php");} else
					if($page=="logout") {
						session_destroy();
						echo "<script>window.location.href='/'</script>";
					} else 
					if($page=="hotel") {include_once("pages/hotel.php");}
					else {
						echo "<script>window.location.href='/'</script>";
					}
				}
				?>
			</section>
		</div>
		<div class="row">
			<footer style='height: 40px'>

			</footer>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>