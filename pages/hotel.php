<?php 
$hotel = getHotelInfo($_GET['id']);

?>
<div>
	<p class='hotel-title'><?php echo $hotel['hotel'];?></p>
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
	<p class='hotel-description-title'>Описание отеля <?php echo $hotel['hotel'];?></p>
	<p class='hotel-description'><?php echo nl2br($hotel['description'])?></p>
</div>