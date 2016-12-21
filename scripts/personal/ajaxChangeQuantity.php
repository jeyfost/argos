<?php

session_start();
include("../connect.php");

$quantity = $mysqli->real_escape_string($_POST['quantity']);
$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("UPDATE basket SET quantity = '".$quantity."' WHERE user_id = '".$_SESSION['userID']."' AND good_id = '".$id."'")) {
	$total = 0;
	$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
	$discount = $discountResult->fetch_array(MYSQLI_NUM);
	$basketResult = $mysqli->query("SELECT * FROM basket WHERE user_id = '".$_SESSION['userID']."'");
	while($basket = $basketResult->fetch_assoc()) {
		$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$basket['good_id']."'");
		$good = $goodResult->fetch_assoc();
		$currencyResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$good['currency']."'");
		$currency = $currencyResult->fetch_array(MYSQLI_NUM);
		$total += $good['price'] * $currency[0] * $basket['quantity'];
	}

	$total = $total - $total * ($discount[0] / 100);
	$total = round($total, 2, PHP_ROUND_HALF_UP);
	$roubles = floor($total);
	$kopeck = ceil(($total - $roubles) * 100);

	if($roubles == 0) {
		$total = $kopeck." коп.";
	} else {
		$total = $roubles." руб. ".$kopeck." коп.";
	}

	echo $total;
}