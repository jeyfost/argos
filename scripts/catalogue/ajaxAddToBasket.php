<?php

session_start();
include("../connect.php");

$goodID = $mysqli->real_escape_string($_POST['goodID']);
$quantity = $mysqli->real_escape_string($_POST['quantity']);

if($quantity > 0) {
	$goodResult = $mysqli->query("SELECT * FROM basket WHERE good_id = '".$goodID."' AND user_id = '".$_SESSION['userID']."'");
	if($goodResult->num_rows == 0) {
		if($mysqli->query("INSERT INTO basket (good_id, quantity, user_id) VALUES ('".$goodID."', '".$quantity."', '".$_SESSION['userID']."')")) {
			echo "a";
		} else {
			echo "b";
		}
	} else {
		$good = $goodResult->fetch_assoc();
		$quantity += $good['quantity'];

		if($mysqli->query("UPDATE basket SET quantity = '".$quantity."' WHERE id = '".$good['id']."'")) {
			echo "c";
		} else {
			echo "b";
		}
	}
}