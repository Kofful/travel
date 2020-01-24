<?php 
if($_SESSION['permit'] != 'admin') {
	echo"<script>window.location.href='/'</script>";
	exit();
}
?>
<form action="index.php?page=admin" method="post" style="background-color:white;box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin: 10px; padding: 10px;">
	<label>Добавить страну:</label><br>
	<input type="text" name="country"><br>
	<button type="submit" class="btn btn-primary" name="btn_country">Добавить</button>
</form>

<form action="index.php?page=admin" method="post" style="background-color:white;box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">
	<label>Страна</label> 
	<select name="country"> 
		<option value='0'>Выбрать страну</option>;
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

<form enctype="multipart/form-data" action="index.php?page=admin" method="post" style="background-color:white;box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">

	<label>Страна</label> 
	<script>
		function onChangeCountry(country) {
			$.post('functions.php', { get_states: 0,country: country.value }, function(data){
				let states = $('#states')[0].options;
				for (i = states.length; i > 0; i--) {
					states[i] = null;
				}
				data = JSON.parse(data);
				states = $('#states');
				data.forEach((state) => {
					states.append("<option value='" +  state['id']+ "'>" + state['state'] + "</option>")
				});
			});
		}
	</script>
	<select id='countries' name="country" onchange="onChangeCountry(this)"> 
		<option value='0'>Выбрать страну</option>;
		<?php
		$countries = getCountries();
		while($row = mysqli_fetch_array($countries)) {
			echo "<option value='".$row['id']. ($row['id'] == $_POST['country'] ? "'selected>" :"'>").$row['country']."</option>";
		}
		?>
	</select><br>
	<label>Город</label>
	<select id="states" name="state">
		<option value='0'>Выбрать город</option>;
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
	<input type="checkbox" name="hot"><label>Сохранить как горящий тур</label><br>
	<label>Описание:</label><br><textarea name="description" maxlength="1300" style="width:100%;height:200px"></textarea><br>
	<label>Картинки:</label><input accept="image/*" type="file" name="image[]" multiple><br>
	<button type="submit" class="btn btn-primary" name="btn_hotel">Добавить</button>
</form>

<form action="index.php?page=admin" method="post" style="background-color:white;box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">
	<label>Удалить отель:</label><br>
	<label>Страна</label> 
	<script>
		function onChangeCountry1(country) {
			$.post('functions.php', { get_states: 0,country: country.value }, function(data){
				let states = $('#states2')[0].options;
				for (i = states.length; i > 0; i--) {
					states[i] = null;
				}
				data = JSON.parse(data);
				states = $('#states2');
				data.forEach((state) => {
					states.append("<option value='" +  state['id']+ "'>" + state['state'] + "</option>")
				});
			});
		}
	</script>
	<select id='countries1' name="country" onchange="onChangeCountry1(this)"> 
		<option value='0'>Выбрать страну</option>;
		<?php
		$countries = getCountries();
		while($row = mysqli_fetch_array($countries)) {
			echo "<option value='".$row['id']. ($row['id'] == $_POST['country'] ? "'selected>" :"'>").$row['country']."</option>";
		}
		?>
	</select><br>
	<label>Город</label>
	<script>
		function onChangeState(state) {
			$.post('functions.php', { get_hotels: 0,state: state.value, country:$('#countries')[0]['value'] }, function(data){
				let hotels = $('#hotels')[0].options;
				for (i = hotels.length; i > 0; i--) {
					hotels[i] = null;
				}
				data = JSON.parse(data);
				hotels = $('#hotels');
				data.forEach((hotel) => {
					console.log(hotel);
					hotels.append("<option value='" +  hotel['id']+ "'>"	 + hotel['hotel'] + "</option>")
				});
			});
		}
	</script>
	<select id="states2" name="state" onchange="onChangeState(this)">
		<option value='0'>Выбрать город</option>;
		<?php
		if(isset($_POST['states1'])) {
			while($row = mysqli_fetch_array($_POST['states1'])) {
				echo "<option value='".$row['id']. ($row['id'] == $_POST['state'] ? "'selected>" :"'>").$row['state']."</option>";
			}
		}
		?>
	</select><br>
	<label>Отель:</label>
	<select id="hotels" name="hotel">
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
