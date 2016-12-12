<?php

include("../connect.php");
session_start();

$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

if($basketQuantity[0] == 0) {
	echo "a";
} else {
	$goodID = $mysqli->real_escape_string($_POST['goodID']);

	$goodResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."' AND good_id = '".$goodID."'");
	$good = $goodResult->fetch_array(MYSQLI_NUM);

	if($good[0] == 0) {
		$quantity = $basketQuantity[0] + 1;
	} else {
		$quantity = $basketQuantity[0];
	}

	echo $quantity;
}