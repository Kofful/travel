<?php
if(isset($_GET['room_id']) && isset($_GET['daterange'])) {
    $hotel = getHotelInfo($_GET['id'], $_GET['daterange']);
} else if(isset($_GET['id'])) {
    //get hotel
} else {
    //show 404
}
?>
<div>
	<p class='hotel-title'><?php echo $hotel['hotel'];?></p>
	<?php
	echo "<p class='hotel-location'>".$hotel['country'].", ".$hotel['state']."</p>"
	?>
	<div class='image-container'>
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="height:400px; width:600px;overflow: hidden;">
			<div class="carousel-inner">
				<?php
				for($i = 0; $i < sizeof($hotel['photos']); $i++) {
					echo"
					<div style='transition: 200ms !important;' class='carousel-item".($i == 0 ? " active" : "")."'>
					<img style='height:400px;object-fit:cover;' src='../images/uploads/".$hotel['photos'][$i]."'' class='d-block w-100'>
					</div>";
				}
				?>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

		<form action="index.php?page=apply&id=<?php echo $hotel['id']?>" class='right-form' method="post">
			<p class='title-form'>Оставить заявку</p>
			<label class='label-form'>Имя</label>
			<input class='form-control' placeholder="Введите имя" type='text' required>
			<label class='label-form'>Телефон</label>
			<input class='form-control' type='tel' placeholder="Пример: 0660006600" pattern="\d{10}" minlength="10" maxlength="10" required>
			<button class='btn btn-warning btn-form'>Отправить</button>
			<p class="hotel-price-add"><span class='hotel-price'><? echo "1kk" . " грн " //TODO show real price?></span> с человека за ночь.</p>
		</form>
	</div>
	<p class='hotel-description-title'>Описание отеля <?php echo $hotel['hotel'];?></p>
	<div class='hotel-description'><?php echo nl2br($hotel['description'])?></div>
</div>