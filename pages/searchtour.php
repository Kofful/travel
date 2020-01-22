<div style='background-color: lightblue; width:100%'>
	<form action="index.php?page=searchtour" method="post">
		<div style="width:100%;margin:10px;">
			<select class="custom-select" style='width:200px;' id="countries" name="country">
				<option value="0">Выбрать страну</option>
				<?php
				$countries = getCountries();
				while($row = mysqli_fetch_array($countries)) {
					echo "<option value='".$row['id']. ($row['id'] == $_POST['country'] ? "'selected>" :"'>").$row['country']."</option>";
				}
				?>
			</select>
			<button type="submit" class="btn btn-primary" name="btn_find_hotels">Получить города</button>
		</div>
		<div style="width:100%;margin:10px;">
			<select class="custom-select" style='width:200px;' id="states" name = "state">
				<option value="0">Выбрать город</option>
				<?php
				if(isset($_POST['states1'])) {
					while($row = mysqli_fetch_array($_POST['states1'])) {
						echo "<option value='".$row['id']. ($row['id'] == $_POST['state'] ? "'selected>" :"'>").$row['state']."</option>";
					}
				}
				?>
			</select>
		</div>
		<button style='margin:10px;' type="submit" class='btn btn-primary' name='btn_find_hotels'>Поиск</button>
	</form>
</div>
<?php 
if(isset($_POST['btn_find_hotels'])) {
	if(isset($_POST['hotels'])) {
		$hotels = $_POST['hotels'];	
		for($i = 0; $i < sizeof($hotels); $i++) {
			showHotel($hotels[$i]);
		}
	}
} else {
	$hotels = getHotels();
	$result = array();
	$i = 0;
	while($row = mysqli_fetch_array($hotels)) {
		$result[$i] = $row;
		$result[$i]['photos'] = array();
		$photos = getPhotos($row['id']);
		$j = 0;
		while($photo = mysqli_fetch_array($photos)) {
			$result[$i]['photos'][$j] = $photo;
			$j++;
		}
		$i++;
	}
	for($i = 0; $i < sizeof($result); $i++) {
		showHotel($result[$i]);
	}
}
//вывести отель на экран
function showHotel($hotel) {
	echo "<div class='list-item'>
	<img src='../images/uploads/".$hotel['photos'][0]['path']."' style='min-width:200px;width:200px;height:133px;align-self:center'>
	<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>
	<a href='/index.php?page=hotel&id=".$hotel['id']."' class='title'>".$hotel['hotel']."</a>
	<p class='description'>". (mb_strlen($hotel['description']) > 300 ? (mb_substr($hotel['description'], 0, 300, 'UTF-8')."...") : $hotel['description']) ."</p>
	<p class='price'>".$hotel['price']." ГРН</p>
	</div>
	</div>";
}
?>
