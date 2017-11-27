<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.04.2017
 * Time: 7:51
 */

include("../../connect.php");

$req = false;
ob_start();

$name = $mysqli->real_escape_string($_POST['name']);
$email = $mysqli->real_escape_string($_POST['email']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$district = $_POST['district'];
$group = $_POST['group'];
$text = $_POST['text'];
$hash = md5(rand(0, 1000000).md5(date("d-m-Y H:i:s")."; ".$email));

if($text == "<p><br></p>") {
	$text = "";
}

if($phone != '') {
	$phoneCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE phone = '".$phone."'");
	$phoneCheck = $phoneCheckResult->fetch_array(MYSQLI_NUM);
}

$nameCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE name = '".$name."'");
$nameCheck = $nameCheckResult->fetch_array(MYSQLI_NUM);

if($nameCheck[0] == 0) {
	$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE email = '".$email."'");
	$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

	if($emailCheck[0] == 0) {
		if($district != "") {
			if($group != "") {
				if($phone != '' and $phoneCheck[0] == 0) {
					if($mysqli->query("INSERT INTO clients (email, name, location, hash, in_send, disactivation_date, phone, notes, filter) VALUES ('".$email."', '".$name."', '".$district."', '".$hash."', '1', '0000-00-00 00:00:00', '".$phone."', '".$text."', '".$group."')")) {
						echo "ok";
					} else {
						echo "failed";
					}
				} else {
					if($phone == '') {
						if($mysqli->query("INSERT INTO clients (email, name, location, hash, in_send, disactivation_date, notes, filter) VALUES ('".$email."', '".$name."', '".$district."', '".$hash."', '1', '0000-00-00 00:00:00', '".$text."', '".$group."')")) {
							echo "ok";
						} else {
							echo "failed";
						}
					} else {
						echo "phone";
					}
				}
			} else {
				echo "group";
			}
		} else {
			echo "district";
		}
	} else {
		echo "email";
	}
} else {
	echo "name";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;