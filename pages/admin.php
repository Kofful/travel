<?php 
if($_SESSION['permit'] != 'admin') {
	echo"<script>window.location.href='/'</script>";
	exit();
}
?>
<form action="index.php?page=admin" method="post" style="box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin: 10px; padding: 10px;">
	<label>Добавить страну:</label><br>
	<input type="text" name="country"><br>
	<button type="submit" class="btn btn-primary" name="btn_country">Добавить</button>
</form>

<form action="index.php?page=admin" method="post" style="box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">
	<label>Страна</label> 
	<select name="country"> 
		<?php
		$countries = getCountries();
		while($row = mysqli_fetch_array($countries)) {
			echo "<option value='".$row['id']."'>".$row['country']."</option>";
		}
		?>
	</select>
	<button type="submit" class="btn btn-danger" name="btn_country_del">Удалить страну</button><br>
	<label>Добавить город:</label><br>
	<input type="text" name="state"><br>
	<button type="submit" class="btn btn-primary" name="btn_state">Добавить</button>
</form>

<form enctype="multipart/form-data" action="index.php?page=admin" method="post" style="box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">

	<label>Страна</label> 
	<script>
		function onChangeCountry() {
			$.post('functions.php', { btn_get_states: 0,country: 12 }, function(data){
				alert('ajax completed. Response:  '+ data);
                    //do after submission operation in DOM
                });
		}
	</script>
	<select id='countries' name="country" onchange="onChangeCountry()"> 
		<?php
		$countries = getCountries();
		while($row = mysqli_fetch_array($countries)) {
			echo "<option value='".$row['id']. ($row['id'] == $_POST['country'] ? "'selected>" :"'>").$row['country']."</option>";
		}
		?>
	</select><button type="submit" class="btn btn-primary" name="btn_get_states">Получить города</button><br>
	<label>Город</label>
	<select id="states" name="state">
		<?php
		if(isset($_POST['states'])) {
			while($row = mysqli_fetch_array($_POST['states'])) {
				echo "<option value='".$row['id']."'>".$row['state']."</option>";
			}
		}
		?>
	</select>
	<button type="submit" class="btn btn-danger" name="btn_state_del">Удалить город</button><br>
	<label>Добавить отель:</label><br>
	<label>Название:</label><input type="text" name="hotel"><br>
	<label>Цена:</label><input type="number" name="price"><br>
	<label>Описание:</label><input type="text" name="description"><br>
	<label>Картинки:</label><input accept="image/*" type="file" name="image[]" multiple><br>
	<button type="submit" class="btn btn-primary" name="btn_hotel">Добавить</button>
</form>

<form action="index.php?page=admin" method="post" style="box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">
	<label>Удалить отель:</label><br>
	<label>Страна</label> 
	<script>
		function onChangeCountry() {
			$.post('functions.php', { btn_get_states: 0,country: 12 }, function(data){
				alert('ajax completed. Response:  '+ data);
                    //do after submission operation in DOM
                });
		}
	</script>
	<select id='countries' name="country" onchange="onChangeCountry()"> 
		<?php
		$countries = getCountries();
		while($row = mysqli_fetch_array($countries)) {
			echo "<option value='".$row['id']. ($row['id'] == $_POST['country'] ? "'selected>" :"'>").$row['country']."</option>";
		}
		?>
	</select><button type="submit" class="btn btn-primary" name="btn_get_states1">Получить города</button><br>
	<label>Город</label>
	<select id="states2" name="state">
		<?php
		if(isset($_POST['states1'])) {
			while($row = mysqli_fetch_array($_POST['states1'])) {
				echo "<option value='".$row['id']. ($row['id'] == $_POST['state'] ? "'selected>" :"'>").$row['state']."</option>";
			}
		}
		?>
	</select><button type="submit" class="btn btn-primary" name="btn_get_hotels">Получить отели</button><br>
	<label>Отель:</label>
	<select name="hotel">
		<?php
		if(isset($_POST['hotels'])) {
			while($row = mysqli_fetch_array($_POST['hotels'])) {
				echo "<option value='".$row['id']."'>".$row['hotel']."</option>";
			}
		}
		?>
	</select>
	<button type="submit" class="btn btn-danger" name="btn_hotel_del">Удалить отель</button>
</form>
