<?php
include_once("functions.php");
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/refresh.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../css/styles.css">
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
        <?php
        include_once("pages/menu.php");
        ?>
    </div>
    <div class="row">
        <section style='width:100%;'>
            <?php
            if ($_SERVER['REQUEST_URI'] == "/") {
                include_once("pages/main.php");
            } else
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    if ($page == "searchtour") {
                        include_once("pages/searchtour.php");
                    } else
                        if ($page == "admin") {
                            include_once("pages/admin.php");
                        } else
                            if ($page == "login") {
                                include_once("pages/login.php");
                            } else
                                if ($page == "register") {
                                    include_once("pages/register.php");
                                } else
                                    if ($page == "apply") {
                                        include_once("pages/apply.php");
                                    } else
                                        if ($page == "logout") {
                                            session_destroy();
                                            echo "<script>window.location.href='/'</script>";
                                        } else
                                            if ($page == "hotel") {
                                                include_once("pages/hotel.php");
                                            } else {
                                                echo "<script>window.location.href='/'</script>";
                                            }
                } else {
                    echo "<script>window.location.href='/'</script>";
                }
            ?>
        </section>
    </div>
</div>
<div class="col-md-12 col-lg-12 d-xs-none"
     style='display:flex; height: 250px; width:100%;background-color: #aaa;margin-top: 50px;padding: 10px 0 0 0;'>
    <div class="col-sm-4 col-md-4 col-lg-4">
        <footer>
            <div>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); margin-top: 10px;" href="/">Главная</a><br>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); " href="/index.php?page=searchtour">Поиск
                    туров</a><br>
                <a style="margin-left: 30px; color:rgba(0,0,0,0.8); " href="/index.php?page=searchtour&hot=1">Горящие
                    туры</a><br>
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>