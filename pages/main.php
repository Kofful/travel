
<?php
function showHotel($hotel) {//id - ID номера, hotel_id - ID отеля
	echo "<div class='main-list-item'>
	<img style='min-width:250px;width:250px;height:166px;' src = '../images/uploads/".$hotel['path']."'>
	<a href='/index.php?page=hotel&id=".$hotel['hotel_id']."&room_id=".$hotel['id']."' class='main-title'>".$hotel['hotel']."</a>
	<p class='main-location'>".$hotel['country'].", ".$hotel['state']."</p>
	<p class='main-price'>".($hotel['room_price'] + $hotel['transfer_price'])." грн</p></div>";
}
?>
<div class='main-section'>
	<p class="title-hot">Горящие туры</p>
	<div style="display: flex;flex-wrap: wrap;justify-content: space-around;">
		<?php
        //TODO show info about nights, dates, places
		//получить горящие туры
		$hotels = getMainHotels(1);
		print_r($hotels);
        foreach ($hotels as $row) {
            showHotel($row);
        }
		?>
	</div>
	<div style="display:flex;justify-content: center;margin:10px;"><a class="btn btn-outline-warning btn-main" href="/index.php?page=searchtour&hot=1">Смотреть все</a></div>
</div>

<p class="title-hot">Популярно сегодня</p>
<div style="display: flex;flex-wrap: wrap;justify-content: space-around;">
	<?php
//получить популярные туры
	$hotels = getMainHotels(0);
	foreach ($hotels as $row) {
		showHotel($row);
	}
	?>
</div>
<div style="display:flex;justify-content: center;"><a class="btn btn-outline-warning btn-main" href="/index.php?page=searchtour">Смотреть все</a></div>