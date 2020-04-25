<nav class="navbar navbar-expand-lg navbar-light bg-light" role="group" aria-label="Basic example" style="width:100%;box-shadow:0 0 2px 2px rgba(0,0,0,0.1);">
	<ul class="navbar-nav mr-auto" id="navbar">
		<li class="nav-item"><a type="button" class="nav-link <?php if(!isset($_GET['page'])){echo 'active';}?>" href="/">Главная</a></li>
		<li class="nav-item"><a type="button" class="nav-link <?php if($_GET['page']=="searchtour" && $_GET['hot']!=1){echo 'active';}?>" href="index.php?page=searchtour">Поиск туров</a></li>
		<li class="nav-item"><a type="button" class="nav-link <?php if($_GET['page']=="searchtour" && $_GET['hot']==1){echo 'active';}?>" href="index.php?page=searchtour&hot=1">Горящие туры</a></li>
	</ul>
	<?php
	if(!isset($_SESSION['permit'])) {
		echo "<a class='btn btn-warning my-2 my-sm-0' type='submit' style='margin-right:10px;color:white;'' href='index.php?page=register'>Регистрация</a>
	<a class='btn btn-success my-2 my-sm-0' type='submit' style='color:white;'href='index.php?page=login'>Вход</a>";
	} else {
		if($_SESSION['permit'] == 'admin') {
			echo "<a type='button' class='btn btn-info' href='index.php?page=admin' style='margin-right:10px;'>Admin</a>";
		}
		echo "<a type='submit' name='btn_logout' href='/index.php?page=logout' class='btn btn-danger'>Выйти</a>";
	}
	?>
	
</nav>