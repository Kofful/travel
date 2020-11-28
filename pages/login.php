<?php
if(isset($_SESSION['permit'])) {
	echo "<script>window.location.href = '/'</script>";
	exit();
}
$login = login();
if(!isset($login['message'])) {
	echo "<form action='index.php?page=login' method='post' style='box-shadow:0 0 4px 4px rgba(0,0,0,0.1); padding:20px; margin-top:20px;width:500px;height:250px;background-color:white;	
  top:0;
  bottom:0;
  left:0;
  right:0;
  margin:auto;'>
	<div class='form-group'>
	<label for='inputLogin'>Логин</label>
	<input type='text' class='form-control' id='inputLogin' name='login' value='".$login['login']."'>
	</div>
	<div class='form-group'>
	<label for='exampleInputPassword1'>Пароль</label>
	<input type='password' class='form-control' id='exampleInputPassword1' name='password' value='".$login['password']."'>
	</div>
	<button type='submit' class='btn btn-success' name='btn_login' style='width:100%;'>Войти</button>";
	if(!isset($login['new'])) {
	   	echo"<span class='form-text' style='color:#f00;'>Неверный E-mail или пароль</span>";
	}
	echo "</form>";
} else if($login['message'] == 'admin') {
	$_SESSION['permit'] = 'admin';
	echo "<script>window.location.href = '/index.php?page=admin'</script>";
} else {
	$_SESSION['permit'] = 'user';
	echo "<script>window.location.href = '/'</script>";
}
?>