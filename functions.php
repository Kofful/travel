<?php
//добавление страны
if(isset($_POST['btn_country'])) {
	$country = $_POST['country'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "INSERT INTO `countries`(id, country) VALUES ('', '$country')";
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
	}
	mysqli_close($link);
}
//удаление страны
if(isset($_POST['btn_country_del'])) {
	$country_id = $_POST['country'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if($country_id) {
		if(!$link) {
			echo "No connection1<br>" . mysqli_connect_error();
			exit();
		} else {
			$query = "SELECT * FROM `photos` WHERE hotel_id IN (SELECT id FROM `hotels` WHERE state_id IN (SELECT id FROM `states` WHERE country_id = $country_id))";
			$uploaddir = 'D:/OSPanel/domains/travel/images/uploads/';
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_array($result)) {
				unlink($uploaddir.$row['path']);
			} 
			$query = "DELETE FROM `countries` WHERE id = $country_id";
			if(!mysqli_query($link, $query)) {
				echo"No connection2 " . mysqli_connect_error();
				exit();
			} 
		}
		mysqli_close($link);
	}
}
//добавление города
if(isset($_POST['btn_state'])) {
	$country_id = $_POST['country'];
	$state = $_POST['state'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection1<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "INSERT INTO `states`(id, state, country_id) VALUES ('', '$state', $country_id)";
		if(!mysqli_query($link, $query)) {
			echo"No connection2 " . mysqli_connect_error();
			exit();
		} 
	}
	mysqli_close($link);
}
//удаление города
if(isset($_POST['btn_state_del'])) {
	$state_id = $_POST['state'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if($state_id) {
		if(!$link) {
			echo "No connection1<br>" . mysqli_connect_error();
			exit();
		} else {
			$query = "SELECT * FROM `photos` WHERE hotel_id IN (SELECT id FROM `hotels` WHERE state_id = $state_id)";
			$uploaddir = 'D:/OSPanel/domains/travel/images/uploads/';
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_array($result)) {
				unlink($uploaddir.$row['path']);
			} 
			$query = "DELETE FROM `states` WHERE id = $state_id";
			if(!mysqli_query($link, $query)) {
				echo"No connection2 " . mysqli_connect_error();
				exit();
			} 
		}
		mysqli_close($link);
	}
}
//добавление отеля
if(isset($_POST['btn_hotel'])) {
	$state_id = $_POST['state'];
	$hotel = $_POST['hotel'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$image = $_POST['image'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if($state_id) {
		if(!$link) {
			echo "No connection1<br>" . mysqli_connect_error();
			exit();
		} else {
			$query = "INSERT INTO `hotels` (id, hotel, price, description, state_id) VALUES ('', '$hotel', '$price', '$description', '$state_id')";
			if(!mysqli_query($link, $query)) {
				echo"No connection2 " . mysqli_connect_error();
				exit();
			} 
			$uploaddir = 'D:/OSPanel/domains/travel/images/uploads/';
			$total = count($_FILES['image']['name']);
			$files = array();
			for($i = 0; $i < $total; $i++) {
				$filename = basename(str_replace(" ", "", str_replace(".", "", microtime())).".".explode("/", $_FILES['image']['type'][$i])[1]);
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
			for($i = 0; $i < $total; $i++) {
				$query.="('', '$files[$i]', $id)";
				if($i < $total - 1) {
					$query.=",";
				}
			}
			if(!mysqli_query($link, $query)) {
				echo"No connection3 " . mysqli_connect_error();
				exit();
			} 
		}
	}
	mysqli_close($link);
}

//удаление отеля
if(isset($_POST['btn_hotel_del'])) {
	$hotel_id = $_POST['hotel'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if($hotel_id) {
		if(!$link) {
			echo "No connection1<br>" . mysqli_connect_error();
			exit();
		} else {
			$query = "SELECT * FROM `photos` WHERE hotel_id = $hotel_id";
			$uploaddir = 'D:/OSPanel/domains/travel/images/uploads/';
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_array($result)) {
				unlink($uploaddir.$row['path']);
			} 
			$query = "DELETE FROM `hotels` WHERE id = $hotel_id";
			if(!mysqli_query($link, $query)) {
				echo"No connection2 " . mysqli_connect_error();
				exit();
			} 
		}
	}
	mysqli_close($link);
}

//получение городов
if(isset($_POST['btn_get_states'])) {
	$index= $_POST['country'];
	$_POST['states'] = getStates($index);
}
//получение городов
if(isset($_POST['btn_get_states1'])) {
	$index= $_POST['country'];
	$_POST['states1'] = getStates($index);
}

//получить отели
if(isset($_POST['btn_get_hotels'])) {
	if(isset($_POST['state'])) {
		$index = $_POST['state'];
	}
	if(isset($_POST['country'])) {
		$country = $_POST['country'];
	}
	$_POST['states1'] = getStates($country);
	$_POST['hotels'] = getHotels($index, $country);
}


//получить отели с выборкой
if(isset($_POST['btn_find_hotels'])) {
	if(isset($_POST['state'])) {
		$index = $_POST['state'];
	}
	if(isset($_POST['country'])) {
		$country = $_POST['country'];
	}
	$_POST['states1'] = getStates($country);
	$hotels = getHotels($index, $country);
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
	$_POST['hotels'] = $result;
}

//регистрация
function clean($value = "") {
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);

	return $value;
}
function check_length($value = "") {
	$result = (mb_strlen($value) < 3 || mb_strlen($value) > 32);
	return !$result;
}
function register() {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$login = $_POST['login'];
	$password2 = $_POST['password2'];
	$email = clean($email);
	$password = clean($password);
	$login = clean($login);
	$password2 = clean($password2);
	if(!isset($_POST['btn_register'])) {
		return array('email' => '', 'password'=>'', 'message'=>'new');
	}	
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!empty($email) && !empty($password) && !empty($login) && !empty($password2)) {
		if(check_length($email) && check_length($password) && check_length($login) && check_length($password2)) {
			if(!$link) {
				echo "No connection1<br>" . mysqli_connect_error();
				exit();
			} else {
				if($password != $password2) {
					return array("email"=>$email, "password"=>$password, "login" => $login, "password2"=>$password2, "message"=>'password');
				}
				$password_hash = md5($password);
				$query = "INSERT INTO `users` (id, login, email, password) VALUES ('','$login' ,  '$email', '$password_hash')";
				if(mysqli_query($link,$query)) {
					return "success";
				} else {
					if(gettype(strpos(mysqli_error($link), "Duplicate")) != "boolean") {
						return array('email' => $email, 'password'=>$password, "login" => $login, 'message'=>'duplicate',"password2"=>$password2);
					}
					return array('email' => $email, 'password'=>$password);
				}
			}
		}
	}
	return array("email"=>$email, "password"=>$password, "login" => $login, "password2"=>$password2, "message"=>'length');
	mysqli_close($link);
}
//вход пользователя
function login() {
	$login = $_POST['login'];
	$password = $_POST['password'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(isset($login) && isset($password)) {
		if(!$link) {
			echo "No connection1<br>" . mysqli_connect_error();
			exit();
		} else {
			$password_hash = md5($password);
			$query = "SELECT * FROM `users` WHERE password = '$password_hash' AND login = '$login'";
			if($row = mysqli_fetch_array(mysqli_query($link,$query))) {
				if($row['is_admin']) {
					return array('login' => $login,'message' => 'admin');
				}
				else {
					return array('login' => $login, 'message' => 'user');
				}
			} else {
				return array('login' => $login, 'password'=>$password, );
			}
		}
	} else {
		return array('login' => '', 'password'=>'', 'new'=>'true');
	}
	mysqli_close($link);
}



//получение стран
function getCountries() {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "SELECT * FROM `countries` ORDER BY country ASC";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
		return $result;
	}
	mysqli_close($link);
}
//получение городов
function getStates($index) {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "SELECT * FROM `states` WHERE country_id = $index ORDER BY state ASC";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
		return $result;
	}
	mysqli_close($link);
}
//получение отелей
function getHotels($state = 0, $country = 0) {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		if($country == 0) {
			$query = "SELECT * FROM `hotels`";
			$result = mysqli_query($link, $query);
			if(!mysqli_query($link, $query)) {
				echo "No connection " . mysqli_connect_error();
				exit();
			} 
			return $result;
		} else if($state == 0) {
			$query = "SELECT * FROM `hotels` WHERE state_id IN (SELECT id FROM `states` WHERE country_id = $country)";
			$result = mysqli_query($link, $query);
			if(!mysqli_query($link, $query)) {
				echo "No connection " . mysqli_error($link);
				exit();
			} 
			return $result;
		} else {
			$query = "SELECT * FROM `hotels` WHERE state_id = $state";
			$result = mysqli_query($link, $query);
			if(!mysqli_query($link, $query)) {
				echo "No connection " . mysqli_connect_error();
				exit();
			} 
			return $result;
		}
	}
	mysqli_close($link);
}
//получить фотографии отеля
function getPhotos($hotel) {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "SELECT * FROM `photos` WHERE hotel_id = $hotel";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
		return $result;
	}
	mysqli_close($link);
}

function getHotelInfo($id) {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "SELECT * FROM `hotels` WHERE id = $id";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo "No connection " . mysqli_connect_error();
			exit();
		} 
		$hotel = mysqli_fetch_array($result);
		$query = "SELECT * FROM `photos` WHERE hotel_id = $id";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
		$hotel['photos'] = array();
		$i=0;
		while($row = mysqli_fetch_array($result)) {
			$hotel['photos'][$i] = $row['path'];
			$i++;
		}
		return $hotel;
	}
}
?>