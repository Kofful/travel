<?php
function showHotel($hotel)
{//id - ID номера, hotel_id - ID отеля
    $nights_word = $hotel['nights'] . (($hotel['nights'] == 2 || $hotel['nights'] == 3 || $hotel['nights'] == 4) ? " ночи" : /* при условии, что ночей от 1 до 21*/
        (($hotel['nights'] > 4 && $hotel['nights'] < 21) ? " ночей" : " ночь"));
    $places_word = $hotel['places']. (($hotel['places'] == 2 || $hotel['places'] == 3 || $hotel['places'] == 4) ? " человека" : " человек");
    $dispatch1 = date("Y-m-d", strtotime($hotel['dispatch']));
    $dispatch2 = date("Y.m.d", strtotime("{$dispatch1}+{$hotel['nights']} days"));
    $daterange =  (str_replace("-", ".",$dispatch1) . "+-+" . $dispatch2);
    echo "<div class='main-list-item'>
<div class='img-div' >
<div class='main-gradient-div'>
<div>
<p>{$hotel['dispatch']}</p> 
<p>({$nights_word})</p>
</div>
<p>{$places_word}" /*при условии, что людей от 1 до 21*/ ."</p> 
</div>
	<img class='main-img' src = '../images/uploads/" . $hotel['path'] . "'>
	</div>  
	<a href='/index.php?page=hotel&id=".$hotel['hotel_id']."&room_id=" . $hotel['id'] . "&daterange=". $daterange."' class='main-title'>" . $hotel['hotel'] . "</a>
	<p class='main-location'>" . $hotel['country'] . ", " . $hotel['state'] . "</p>
	<p class='main-price'>" . $hotel['price'] . " грн</p>
	</div>";
}

?>
<div class='main-section'>
    <p class="title-hot">Горящие туры</p>
    <div style="display: flex;flex-wrap: wrap;justify-content: space-around;">
        <?php
        //TODO show info about nights, dates, places
        //получить горящие туры
        $hotels = getMainHotels(1);
        foreach ($hotels as $row) {
            showHotel($row);
        }
        ?>
    </div>
    <div style="display:flex;justify-content: center;margin:10px;"><a class="btn btn-outline-warning btn-main"
                                                                      href="/index.php?page=searchtour&hot=1">Смотреть
            все</a></div>
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
<div style="display:flex;justify-content: center;"><a class="btn btn-outline-warning btn-main"
                                                      href="/index.php?page=searchtour">Смотреть все</a></div>