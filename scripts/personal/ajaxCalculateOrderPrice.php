<?php

session_start();
include("../connect.php");

$id = $mysqli->real_escape_string($_POST['orderID']);
$total = 0;
$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);
$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");
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

if($roubles == 0) {
	$total = $kopeck." коп.";
} else {
	$total = $roubles." руб. ".$kopeck." коп.";
}

echo $total;