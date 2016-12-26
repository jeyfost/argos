<?php

session_start();
include("../connect.php");

$quantity = $mysqli->real_escape_string($_POST['quantity']);
$id = $mysqli->real_escape_string($_POST['id']);
$orderID = $mysqli->real_escape_string($_POST['orderID']);

if($mysqli->query("UPDATE orders SET quantity = '".$quantity."' WHERE good_id = '".$id."' AND order_id = '".$orderID."'")) {
	$total = 0;
	$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
	$discount = $discountResult->fetch_array(MYSQLI_NUM);
	$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$orderID."'");
	while($order = $orderResult->fetch_assoc()) {
		$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$order['good_id']."'");
		$good = $goodResult->fetch_assoc();
		$currencyResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$good['currency']."'");
		$currency = $currencyResult->fetch_array(MYSQLI_NUM);
		$total += $good['price'] * $currency[0] * $order['quantity'];
	}

	$total = $total - $total * ($discount[0] / 100);
	$total = round($total, 2, PHP_ROUND_HALF_UP);
	$roubles = floor($total);
	$kopeck = ceil(($total - $roubles) * 100);
	if($kopeck == 100) {
		$kopeck = 0;
		$roubles++;
	}

	if($roubles == 0) {
		$total = $kopeck." коп.";
	} else {
		$total = $roubles." руб. ".$kopeck." коп.";
	}

	echo $total;
}