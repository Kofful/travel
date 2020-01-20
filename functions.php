<?php
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

if(isset($_POST['btn_country_del'])) {
	$country_id = $_POST['country'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection1<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "DELETE FROM `countries` WHERE id = $country_id";
		if(!mysqli_query($link, $query)) {
			echo"No connection2 " . mysqli_connect_error();
			exit();
		} 
	}
	mysqli_close($link);
}

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

if(isset($_POST['btn_state_del'])) {
	$state_id = $_POST['state'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection1<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "DELETE FROM `states` WHERE id = $state_id";
		if(!mysqli_query($link, $query)) {
			echo"No connection2 " . mysqli_connect_error();
			exit();
		} 
	}
	mysqli_close($link);
}

if(isset($_POST['btn_hotel'])) {
	$state_id = $_POST['state'];
	$hotel = $_POST['hotel'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$image = $_POST['image'];
	$link = mysqli_connect("localhost", "root", "12345", "travel");
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
			move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploadfile);
		}
		$query = "SELECT id FROM `hotels` WHERE hotel = '$hotel'";
		$result = mysqli_fetch_array(mysqli_query($link, $query))["id"];
		$query = "INSERT INTO `photos` (id, path, hotel_id) VALUES ";
		for($i = 0; $i < $total; $i++) {
			$query.="('', '$files[$i]', $result)";
			if($i < $total - 1) {
				$query.=",";
			}
		}
		if(!mysqli_query($link, $query)) {
			echo"No connection3 " . mysqli_connect_error();
			exit();
		} 
	}
	mysqli_close($link);
}



function getCountries() {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "SELECT * FROM `countries`";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
		return $result;
	}
	mysqli_close($link);
}
function getStates() {
	$link = mysqli_connect("localhost", "root", "12345", "travel");
	if(!$link) {
		echo "No connection<br>" . mysqli_connect_error();
		exit();
	} else {
		$query = "SELECT * FROM `states`";
		$result = mysqli_query($link, $query);
		if(!mysqli_query($link, $query)) {
			echo"No connection " . mysqli_connect_error();
			exit();
		} 
		return $result;
	}
	mysqli_close($link);
}
?>