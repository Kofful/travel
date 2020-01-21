<?php 
if(isset($_SESSION['permit'])) {
	echo "<script>window.location.href = '/'</script>";
	exit();
}
$register = register();
if($register != "success") {
	echo "<form action='index.php?page=register' method='post' style='box-shadow:0 0 4px 4px rgba(0,0,0,0.1); padding:20px; margin-top:20px;'>
	<div class='form-group'>
	<label for='inputLogin'>Логин</label>
	<input type='text' class='form-control' id='inputLogin' name='login' value='".$register['login']."'>
	</div>
	<div class='form-group'>
	<label for='inputEmail'>Почта</label>
	<input type='email' class='form-control' id='inputEmail' name='email' value='".$register['email']."'>
	</div>
	<div class='form-group'>
	<label for='inputPassword1'>Пароль</label>
	<input type='password' class='form-control' id='inputPassword1' name='password' value='".$register['password']."'>
	</div>
	<div class='form-group'>
	<label for='inputPassword2'>Подтверждение пароля</label>
	<input type='password' class='form-control' id='inputPassword2' name='password2' value='".$register['password2']."'>
	</div>
	<button type='submit' class='btn btn-warning' name='btn_register' style='width:100%;'>Зарегистрироваться</button>";
	if(!isset($register['message'])) {
	   	echo"<span class='form-text' style='color:#f00;'>Не все поля заполены.</span>";
	} else if($register['message']== "duplicate") {
	   	echo"<span class='form-text' style='color:#f00;'>Этот Email уже занят.</span>";
	} else if($register['message'] == "length") {
	   	echo"<span class='form-text' style='color:#f00;'>Неверный ввод. Длина строки должна быть от 3 до 32 символов.</span>";
	} else if($register['message'] == "password") {
	   	echo"<span class='form-text' style='color:#f00;'>Пароли не совпадают.</span>";
	}
	echo "</form>";
} else {
	echo "<script>window.location.href = '/index.php?page=login'</script>";
}
?>