<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$total = 0;

$userResult = $mysqli->query("SELECT user_id FROM orders_info WHERE id = '".$id."'");
$user = $userResult->fetch_array(MYSQLI_NUM);
$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$user[0]."'");

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

if($mysqli->query("UPDATE orders_info SET summ = '".$total."', proceed_date = '".date('d-m-Y H:i:s')."', status = '1' WHERE id = '".$id."'")) {
	echo "a";
} else {
	echo "b";
}