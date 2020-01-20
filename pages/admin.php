<form action="index.php?page=admin" method="post" style="border:1px solid #777; margin: 10px; padding: 10px;">
	<label>Добавить страну:</label><br>
	<input type="text" name="country"><br>
	<button type="submit" class="btn btn-primary" name="btn_country">Добавить</button>
</form>

<form action="index.php?page=admin" method="post" style="border:1px solid #777; margin:10px; padding:10px;">
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

<form enctype="multipart/form-data" action="index.php?page=admin" method="post" style="border:1px solid #777; margin:10px; padding:10px;">

	<label>Страна</label> 
	<select name="country"> 
		<?php
		$countries = getCountries();
		while($row = mysqli_fetch_array($countries)) {
			echo "<option value='".$row['id']."'>".$row['country']."</option>";
		}
		?>
	</select><br>
	<label>Город</label>
	<select name="state">
		<?php
		$states = getStates();
		while($row = mysqli_fetch_array($states)) {
			echo "<option value='".$row['id']."'>".$row['state']."</option>";
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
