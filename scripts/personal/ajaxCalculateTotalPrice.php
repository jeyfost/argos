<?php

session_start();
include("../connect.php");

$total = 0;
$basketResult = $mysqli->query("SELECT * FROM basket WHERE user_id = '".$_SESSION['userID']."'");
while($basket = $basketResult->fetch_assoc()) {
	$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$basket['good_id']."'");
	$good = $goodResult->fetch_assoc();
	$currencyResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$good['currency']."'");
	$currency = $currencyResult->fetch_array(MYSQLI_NUM);
	$total += $currency[0] * $good['price'] * $basket['quantity'];
}

$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);

$total = $total - $total * ($discount[0] / 100);
$total = round($total, 2, PHP_ROUND_HALF_UP);
$roubles = floor($total);
$kopeck = ($total - $roubles) * 100;

if($roubles == 0) {
	$total = $kopeck." коп.";
} else {
	$total = $roubles." руб. ".$kopeck." коп.";
}

echo $total;