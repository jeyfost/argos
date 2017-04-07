<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 07.04.2017
 * Time: 9:08
 */

include("../../connect.php");

$req = false;
ob_start();

$name = $mysqli->real_escape_string($_POST['name']);
$email = $mysqli->real_escape_string($_POST['email']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$id = $mysqli->real_escape_string($_POST['id']);
$district = $_POST['district'];
$text = $_POST['text'];

if($text == "<p><br></p>") {
	$text = "";
}

if($phone != '') {
	$phoneCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE phone = '".$phone."' AND id <> '".$id."'");
	$phoneCheck = $phoneCheckResult->fetch_array(MYSQLI_NUM);
}

$nameCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE name = '".$name."' AND id <> '".$id."'");
$nameCheck = $nameCheckResult->fetch_array(MYSQLI_NUM);

if($nameCheck[0] == 0) {
	$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE email = '".$email."' AND id <> '".$id."'");
	$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

	if($emailCheck[0] == 0) {
		$clientResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$id."'");
		$client = $clientResult->fetch_assoc();

		if($_POST['checkbox'] == 1) {
			$inSend = 1;
		} else {
			$inSend = 0;
		}

		if($phone != '' and $phoneCheck[0] == 0) {
			if($client['in_send'] == 0) {
				if($inSend == 1) {
					if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', in_send = '1', disactivation_date = '0000-00-00 00:00:00', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
					{
						echo "ok";
					} else {
						echo "failed";
					}
				} else {
					if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
					{
						echo "ok";
					} else {
						echo "failed";
					}
				}
			} else {
				if($inSend == 0) {
					if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', in_send = '0', disactivation_date = '".date("Y-m-d H:i:s")."', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
					{
						echo "ok";
					} else {
						echo "failed";
					}
				} else {
					if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
					{
						echo "ok";
					} else {
						echo "failed";
					}
				}
			}
		} else {
			if($phone == '') {
				if($client['in_send'] == 0) {
					if($inSend == 1) {
						if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', in_send = '1', disactivation_date = '0000-00-00 00:00:00', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
						{
							echo "ok";
						} else {
							echo "failed";
						}
					} else {
						if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
						{
							echo "ok";
						} else {
							echo "failed";
						}
					}
				} else {
					if($inSend == 0) {
						if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', in_send = '0', disactivation_date = '".date("Y-m-d H:i:s")."', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
						{
							echo "ok";
						} else {
							echo "failed";
						}
					} else {
						if($mysqli->query("UPDATE clients SET email = '".$email."', name = '".$name."', location = '".$_POST['district']."', phone = '".$phone."', notes = '".$text."' WHERE id = '".$id."'"))
						{
							echo "ok";
						} else {
							echo "failed";
						}
					}
				}
			} else {
				echo "phone";
			}
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