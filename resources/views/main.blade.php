<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset("css/refresh.css") }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset("css/styles.css") }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <script src="/ckeditor/ckeditor.js"></script>
    <title>Mandrivka</title>
</head>
<body>
<div class="container">
    <div class="row">
        <header style='width:100%;height: 200px;'>
            <img src="/images/header.jpg" style='width:100%;height:100%;object-fit:cover'>
        </header>
    </div>
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" role="group" aria-label="Basic example" style="width:100%;box-shadow:0 0 2px 2px rgba(0,0,0,0.1);">
            <ul class="navbar-nav mr-auto" id="navbar">
                <li class="nav-item"><a type="button" class="nav-link active" href="/">Главная</a></li>
                <li class="nav-item"><a type="button" class="nav-link" href="/searchtour">Поиск туров</a></li>
                <li class="nav-item"><a type="button" class="nav-link" href="/hottours">Горящие туры</a></li>
                <li class="nav-item"><a type="button" class="nav-link" href="/hotels">Отели</a></li>
            </ul>
            <?php
            if(!isset($_SESSION['permit'])) {
                echo "<a class='btn btn-warning my-2 my-sm-0' type='submit' style='margin-right:10px;color:white;'' href='register'>Регистрация</a>
	<a class='btn btn-success my-2 my-sm-0' type='submit' style='color:white;'href='login'>Вход</a>";
            } else {
                if($_SESSION['permit'] == 'admin') {
                    echo "<a type='button' class='btn btn-info' href='admin' style='margin-right:10px;'>Admin</a>";
                }
                echo "<a type='submit' name='btn_logout' href='/logout' class='btn btn-danger'>Выйти</a>";
            }
            ?>

        </nav>
    </div>
    <div class="row">
        <section style='width:100%;'>
            <?php
list('common_hotels' => $common_hotels,'hot_hotels' => $hot_hotels, 'nights' => $nights, 'dispatch1' => $dispatch1) = $data;
function showHotel($hotel, $nights, $dispatch1)
{//id - ID номера, hotel_id - ID отеля
    $hotel = get_object_vars($hotel);
    $nights_word = $nights . (($nights == 2 || $nights == 3 || $nights == 4) ? " ночи" : /* при условии, что ночей от 1 до 21*/
            (($nights > 4 && $nights < 21) ? " ночей" : " ночь"));
    $places_word = $hotel['places']. (($hotel['places'] == 2 || $hotel['places'] == 3 || $hotel['places'] == 4) ? " человека" : " человек");
    $dispatch2 = date("Y.m.d", strtotime("{$dispatch1}+{$nights} days"));
    $daterange =  (str_replace("-", ".",$dispatch1) . "+-+" . $dispatch2);
    echo "<div class='main-list-item'>
<div class='img-div' >
<div class='main-gradient-div'>
<div>
<p>{$dispatch1}</p> 
<p>({$nights_word})</p>
</div>
<p>{$places_word}" /*при условии, что людей от 1 до 21*/ ."</p> 
</div>
	<img class='main-img' src = '" . URL::to("/images/uploads/" . $hotel['path']) . "'>
	</div>  
	<a href='/hotel?id=".$hotel['hotel_id']."&room_id=" . $hotel['id'] . "&daterange=". $daterange."' class='main-title'>" . $hotel['hotel'] . "</a>
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
        foreach ($hot_hotels as $row) {
            showHotel($row, $nights, $dispatch1);
        }
        ?>
    </div>
    <div style="display:flex;justify-content: center;margin:10px;"><a class="btn btn-outline-warning btn-main"
                                                                      href="/hottours">Смотреть
            все</a></div>
</div>

<p class="title-hot">Популярно сегодня</p>
<div style="display: flex;flex-wrap: wrap;justify-content: space-around;">
    <?php
    //получить популярные туры
    foreach ($common_hotels as $row) {
        showHotel($row, $nights, $dispatch1);
    }
    ?>
</div>
<div style="display:flex;justify-content: center;"><a class="btn btn-outline-warning btn-main"
                                                      href="/searchtour">Смотреть все</a></div>

        </section>
    </div>
</div>
<div class="col-md-12 col-lg-12 d-xs-none"
     style='display:flex; height: 250px; width:100%;background-color: #aaa;margin-top: 50px;padding: 10px 0 0 0;'>
    <div class="col-sm-4 col-md-4 col-lg-4">
        <footer>
            <div>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); margin-top: 10px;" href="/">Главная</a><br>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); " href="/searchtour">Поиск
                    туров</a><br>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); " href="/hottours">Горящие
                    туры</a><br>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); " href="/hotels">Отели</a><br>
            </div>
        </footer>
    </div>
    <div class="col-sm-8 col-md-8 col-lg-8">
        <p>Контакты:</p>
        <p>+38(093)-333-33-33</p>
        <p>+38(098)-888-88-88</p>
        <p>+38(077)-777-77-77</p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>
