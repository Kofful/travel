<div style='background-color: rgba(173, 216, 230, 0.2); width:100%'>
	<form action="index.php?page=searchtour" method="get">
		<input name="page" value="searchtour" style='height: 0;visibility: hidden'>
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
		<div style="margin:10px;">
			<select class="custom-select" style='width:200px;' id="countries" name="country" onchange="onChangeCountry(this)">
				<option value="0">Выбрать страну</option>
				<?php
				$countries = getCountries();
				while($row = mysqli_fetch_array($countries)) {
					echo "<option value='".$row['id']. ($row['id'] == $_GET['country'] ? "'selected>" :"'>").$row['country']."</option>";
				}	
				?>
			</select>
		</div>
		<div style="margin:10px;">
			<select class="custom-select" style='width:200px;' id="states" name = "state">
				<option value="0">Выбрать город</option>
				<?php
				if(isset($_GET['country'])) {
					$states = getStates($_GET['country']);
					if(isset($states)) {
						while($row = mysqli_fetch_array($states)) {
							echo "<option value='".$row['id']. ($row['id'] == $_GET['state'] ? "'selected>" :"'>").$row['state']."</option>";
						}
					}
				}
				?>
			</select>
		</div>
		<button style='margin:10px;' type="submit" class='btn btn-primary'>Поиск</button>
	</form>
</div>
<?php 
$hotels = getHotels($_GET['state'], $_GET['country']);
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
//вывести отель на экран
function showHotel($hotel) {
	echo "<div class='list-item'>
	<img src='../images/uploads/".$hotel['photos'][0]['path']."' style='min-width:200px;width:200px;height:133px;align-self:center'>
	<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>
	<a href='/index.php?page=hotel&id=".$hotel['id']."' class='title'>".$hotel['hotel']."</a>
	<p class='description'>". (mb_strlen($hotel['description']) > 300 ? (mb_substr($hotel['description'], 0, 300, 'UTF-8')."...") : $hotel['description']) ."</p>
	<p class='price'>".$hotel['price']." грн</p>
	</div>
	</div>";
}
?>
