<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "12345");
define("DB_NAME", "travel");
//добавление страны
if (isset($_POST['btn_country'])) {
    $country = $_POST['country'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection<br>" . mysqli_connect_error();
        exit();
    } else {
        $query = "INSERT INTO `countries`(id, country) VALUES ('', '$country')";
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
    }
    mysqli_close($link);
}
//удаление страны
if (isset($_POST['btn_country_del'])) {
    $country_id = $_POST['country'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($country_id) {
        if (!$link) {
            echo "No connection1<br>" . mysqli_connect_error();
            exit();
        } else {
            $query = "SELECT * FROM `photos` WHERE hotel_id IN (SELECT id FROM `hotels` WHERE state_id IN (SELECT id FROM `states` WHERE country_id = $country_id))";
            $uploaddir = 'D:/OSPanel/domains/mandrivka/images/uploads/';
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result)) {
                unlink($uploaddir . $row['path']);
            }
            $query = "DELETE FROM `countries` WHERE id = $country_id";
            if (!mysqli_query($link, $query)) {
                echo "No connection2 " . mysqli_connect_error();
                exit();
            }
        }
        mysqli_close($link);
    }
}
//добавление города
if (isset($_POST['btn_state'])) {
    $country_id = $_POST['country'];
    $state = $_POST['state'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection1<br>" . mysqli_connect_error();
        exit();
    } else {
        $query = "INSERT INTO `states`(id, state, country_id) VALUES ('', '$state', $country_id)";
        if (!mysqli_query($link, $query)) {
            echo "No connection2 " . mysqli_connect_error();
            exit();
        }
    }
    mysqli_close($link);
}
//удаление города
if (isset($_POST['btn_state_del'])) {
    $state_id = $_POST['state'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($state_id) {
        if (!$link) {
            echo "No connection1<br>" . mysqli_connect_error();
            exit();
        } else {
            $query = "SELECT * FROM `photos` WHERE hotel_id IN (SELECT id FROM `hotels` WHERE state_id = $state_id)";
            $uploaddir = 'D:/OSPanel/domains/mandrivka/images/uploads/';
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result)) {
                unlink($uploaddir . $row['path']);
            }
            $query = "DELETE FROM `states` WHERE id = $state_id";
            if (!mysqli_query($link, $query)) {
                echo "No connection2 " . mysqli_connect_error();
                exit();
            }
        }
        mysqli_close($link);
    }
}
//добавление отеля
if (isset($_POST['btn_hotel'])) {
    $state_id = $_POST['state'];
    $hotel = $_POST['hotel'];
    $price = $_POST['price'];
    $hot = $_POST['hot'];
    $hot = $hot == "on" ? 1 : 0;
    $description = $_POST['description'];
    $image = $_POST['image'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($state_id) {
        if (!$link) {
            echo "No connection1<br>" . mysqli_connect_error();
            exit();
        } else {
            $query = "INSERT INTO `hotels` (id, hotel, price, description, state_id, is_hot) VALUES ('', '$hotel', '$price', '$description', '$state_id', $hot)";
            if (!mysqli_query($link, $query)) {
                echo "No connection2 " . mysqli_connect_error();
                exit();
            }
            $uploaddir = 'D:/OSPanel/domains/mandrivka/images/uploads/';
            $total = count($_FILES['image']['name']);
            $files = array();
            for ($i = 0; $i < $total; $i++) {
                $filename = basename(str_replace(" ", "", str_replace(".", "", microtime())) . "." . explode("/", $_FILES['image']['type'][$i])[1]);
                $files[$i] = $filename;
                $uploadfile = $uploaddir . $filename;
                // $file = $_FILES['image']['tmp_name'][$i];
                // $centreX = round($im->getWidth() / 2);
                // $centreY = round($im->getHeight() / 2);

                // $x1 = $centreX - 300;
                // $y1 = $centreY - 200;

                // $x2 = $centreX + 300;
                // $y2 = $centreY + 200;

                // $im->crop($x1, $y1, $x2, $y2);
                move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploadfile);
            }
            $id = mysqli_insert_id($link);
            $query = "INSERT INTO `photos` (id, path, hotel_id) VALUES ";
            for ($i = 0; $i < $total; $i++) {
                $query .= "('', '$files[$i]', $id)";
                if ($i < $total - 1) {
                    $query .= ",";
                }
            }
            if (!mysqli_query($link, $query)) {
                echo "No connection3 " . mysqli_connect_error();
                exit();
            }
        }
    }
    mysqli_close($link);
}

//удаление отеля
if (isset($_POST['btn_hotel_del'])) {
    $hotel_id = $_POST['hotel'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($hotel_id) {
        if (!$link) {
            echo "No connection1<br>" . mysqli_connect_error();
            exit();
        } else {
            $query = "SELECT * FROM `photos` WHERE hotel_id = $hotel_id";
            $uploaddir = 'D:/OSPanel/domains/mandrivka/images/uploads/';
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result)) {
                unlink($uploaddir . $row['path']);
            }
            $query = "DELETE FROM `hotels` WHERE id = $hotel_id";
            if (!mysqli_query($link, $query)) {
                echo "No connection2 " . mysqli_connect_error();
                exit();
            }
        }
    }
    mysqli_close($link);
}

//получение городов jquery
if (isset($_POST['get_states'])) {
    $index = $_POST['country'];
    $resut = array();
    $states = getStates($index);
    $i = 0;
    while ($row = mysqli_fetch_array($states)) {
        $result[$i] = $row;
        $i++;
    }
    echo json_encode($result);
}

//получить отели jquery
if (isset($_POST['get_hotels'])) {
    if (isset($_POST['state'])) {
        $index = $_POST['state'];
    }
    if (isset($_POST['country'])) {
        $country = $_POST['country'];
    }
    if (isset($_POST['hot'])) {
        $hot = $_POST['hot'];
    }
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }
    if (isset($_POST['nutrition'])) {
        $nutrition = $_POST['nutrition'];
    }
    $hotels = getHotels($index, $country, $hot, $nutrition, $page);
    $resut = array();
    $i = 0;
    while ($row = mysqli_fetch_array($hotels)) {
        $photos = getPhotos($row['id']);
        $result[$i] = $row;
        if ($photo = mysqli_fetch_array($photos)) {
            $result[$i]['photo-path'] = $photo["path"];
        }
        $i++;
    }
    echo json_encode($result);
}

//регистрация
function clean($value = "")
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

function check_length($value = "")
{
    $result = (mb_strlen($value) < 3 || mb_strlen($value) > 32);
    return !$result;
}

function register()
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login = $_POST['login'];
    $password2 = $_POST['password2'];
    $email = clean($email);
    $password = clean($password);
    $login = clean($login);
    $password2 = clean($password2);
    if (!isset($_POST['btn_register'])) {
        return array('email' => '', 'password' => '', 'message' => 'new');
    }
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!empty($email) && !empty($password) && !empty($login) && !empty($password2)) {
        if (check_length($email) && check_length($password) && check_length($login) && check_length($password2)) {
            if (!$link) {
                echo "No connection1<br>" . mysqli_connect_error();
                exit();
            } else {
                if ($password != $password2) {
                    return array("email" => $email, "password" => $password, "login" => $login, "password2" => $password2, "message" => 'password');
                }
                $password_hash = md5($password);
                $query = "INSERT INTO `users` (id, login, email, password) VALUES ('','$login' ,  '$email', '$password_hash')";
                if (mysqli_query($link, $query)) {
                    return "success";
                } else {
                    if (gettype(strpos(mysqli_error($link), "Duplicate")) != "boolean") {
                        return array('email' => $email, 'password' => $password, "login" => $login, 'message' => 'duplicate', "password2" => $password2);
                    }
                    return array('email' => $email, 'password' => $password);
                }
            }
        }
    }
    return array("email" => $email, "password" => $password, "login" => $login, "password2" => $password2, "message" => 'length');
    mysqli_close($link);
}

//вход пользователя
function login()
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (isset($login) && isset($password)) {
        if (!$link) {
            echo "No connection1<br>" . mysqli_connect_error();
            exit();
        } else {
            $password_hash = md5($password);
            $query = "SELECT * FROM `users` WHERE password = '$password_hash' AND login = '$login'";
            if ($row = mysqli_fetch_array(mysqli_query($link, $query))) {
                if ($row['is_admin']) {
                    return array('login' => $login, 'message' => 'admin');
                } else {
                    return array('login' => $login, 'message' => 'user');
                }
            } else {
                return array('login' => $login, 'password' => $password,);
            }
        }
    } else {
        return array('login' => '', 'password' => '', 'new' => 'true');
    }
    mysqli_close($link);
}


//получение стран
function getCountries()
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection<br>" . mysqli_connect_error();
        exit();
    } else {
        $query = "SELECT * FROM `countries` ORDER BY country ASC";
        $result = mysqli_query($link, $query);
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
        return $result;
    }
    mysqli_close($link);
}

//получение городов
function getStates($index)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection<br>" . mysqli_connect_error();
        exit();
    } else {
        $query = "SELECT * FROM `states` WHERE country_id = $index ORDER BY state ASC";
        $result = mysqli_query($link, $query);
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
        return $result;
    }
    mysqli_close($link);
}


//получение отелей с выборкой
function getHotels($state = 0, $country = 0, $hot = 0, $nutrition = 0, $page = 0)//page ВСЕГДА ПОСЛЕДНИЙ ПАРАМЕТР!!!!!
{
    $page *= 10;
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection<br>" . mysqli_connect_error();
        exit();
    } else {
        //выбрать все
        $query = "SELECT `hotels`.id,`hotels`.hotel,`hotels`.`price`,`hotels`.`description`, `nutrition`.`name` as nutrition FROM `hotels` JOIN `nutrition` on `nutrition`.id = `hotels`.`nutrition_id` WHERE";
        if ($country == 0) {
            $query .= " state_id > 0";// всегда верно
        } else if ($state == 0) {//выбрать по стране
            $query .= " state_id IN (SELECT id FROM `states` WHERE country_id = $country)";
        } else {//выбрать по городу
            $query .= " state_id = $state";
        }
        if ($hot == 1) {//горящие
            $query .= " AND is_hot = 1";
        }
        if ($nutrition != 0) {//питание
            $query .= " AND nutrition_id = " . $nutrition;
        }
//        if($roomtype != 0) {//тип номера
//            //$query .=
//        }
        $query .= " ORDER BY id DESC LIMIT $page, 10";
        $result = mysqli_query($link, $query);
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
        return $result;
    }
    mysqli_close($link);
}

//получение отелей без выборки
function getMainHotels($hot)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        exit();
    } else {
        $final = array();
        $i = 0;
        while($i < 4) {
            $nights = rand(3, 8);
            $dispatch1 = time();
            $dispatch1 = strtotime("+" . rand(5, 30) . " day", $dispatch1);
            $dispatch2 = strtotime("+$nights day", $dispatch1);
            $query = "SELECT `rooms`.id, `rooms`.`hotel_id`, `rooms`.places,
 (`rooms`.price * {$nights}) as room_price, IFNULL(SUM(`transfers`.price), 0) AS transfer_price, `hotels`.`hotel`,
  `states`.state, `countries`.`country`, `photos`.`path` FROM `rooms` JOIN `hotels` ON `hotels`.id = hotel_id JOIN `states`
   ON `states`.id = `hotels`.`state_id` JOIN `countries` ON `countries`.id = `states`.`country_id` JOIN `photos`
    ON `photos`.id = (SELECT id FROM `photos` WHERE `hotel_id` = `hotels`.id LIMIT 1) LEFT JOIN `transfers`
     ON (`transfers`.`state1_id` = 15 AND `transfers`.state2_id = `states`.id AND `transfers`.`dispatch` = '" . date("Y-m-d", $dispatch1) . "')
      OR (`transfers`.`state1_id` = `states`.id AND `transfers`.state2_id = 15 AND `transfers`.`dispatch` = '" . date("Y-m-d", $dispatch2) . "')";
            if ($hot == 1) {
                $query .= " WHERE is_hot = 1";
            }
            $query .= " GROUP BY id ORDER BY RAND()";
            $result = mysqli_query($link, $query);
            if (!mysqli_query($link, $query)) {
                exit();
            }
            while (($room = mysqli_fetch_array($result))) {
                $flag = true;
                foreach ($final as $item) {
                    if ($item['hotel_id'] == $room['hotel_id']) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    $final[$i] = $room;
                    $final[$i]['nights'] = $nights;
                    $i++;
                    break;
                }
            }
        }
        mysqli_close($link);
        return $final;
    }
}

//получить фотографии отеля
function getPhotos($hotel)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection<br>" . mysqli_connect_error();
        exit();
    } else {
        $query = "SELECT * FROM `photos` WHERE hotel_id = $hotel";
        $result = mysqli_query($link, $query);
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
        mysqli_close($link);
        return $result;
    }
}

//получить информацию об отеле
function getHotelInfo($id)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$link) {
        echo "No connection<br>" . mysqli_connect_error();
        exit();
    } else {
        $query = "SELECT `hotels`.hotel, `hotels`.id, `hotels`.price,`hotels`.description,	 `states`.state, `countries`.country FROM `hotels` JOIN `states` ON `states`.id = `hotels`.state_id JOIN `countries` ON `countries`.id = `states`.country_id WHERE `hotels`.id = $id";
        $result = mysqli_query($link, $query);
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
        $hotel = mysqli_fetch_array($result);
        $query = "SELECT * FROM `photos` WHERE hotel_id = $id";
        $result = mysqli_query($link, $query);
        if (!mysqli_query($link, $query)) {
            echo "No connection " . mysqli_connect_error();
            exit();
        }
        $hotel['photos'] = array();
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $hotel['photos'][$i] = $row['path'];
            $i++;
        }
        return $hotel;
    }
}

//TODO delete this
function addTransfers($state1 = 16, $state2 = 20)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $i = 0;
    $date = strtotime("2020/06/06");
    while ($i < 100) {
        $date = strtotime("+1 day", $date);
        $query = "INSERT INTO `transfers` (state1_id, state2_id, price, dispatch) VALUE (" . $state1 . ", " . $state2 . ", " . rand(40, 60) * 100 . ", " . date("Ymd", $date) . " )";
        $i++;
        mysqli_query($link, $query);
    }

    $i = 0;
    $date = strtotime("2020/06/06");
    while ($i < 100) {
        $date = strtotime("+1 day", $date);
        $query = "INSERT INTO `transfers` (state1_id, state2_id, price, dispatch) VALUE (" . $state2 . ", " . $state1 . ", " . rand(40, 60) * 100 . ", " . date("Ymd", $date) . " )";
        $i++;
        mysqli_query($link, $query);
    }
}

function addRooms()
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = mysqli_query($link, "SELECT id FROM `hotels` WHERE 1");
    while ($hotel_id = mysqli_fetch_array($result)) {
        $type = rand(1, 6);
        $price = rand(20, 40) * 50;
        $places = rand(2, 4);
        $query = "INSERT INTO `rooms` (hotel_id, type_id, price, places) VALUE (" . $hotel_id[0] . ", " . $type . ", " . $price . ", " . $places . ")";
        mysqli_query($link, $query);
        mysqli_query($link, $query);
    }
}

?>