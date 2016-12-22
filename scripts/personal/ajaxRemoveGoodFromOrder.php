<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

$orderID = $mysqli->real_escape_string($_POST['orderID']);
$goodID = $mysqli->real_escape_string($_POST['goodID']);

if($mysqli->query("DELETE FROM orders WHERE order_id = '".$orderID."' AND good_id = '".$goodID."'")) {
	$quantityResult = $mysqli->query("SELECT COUNT(id) FROM orders WHERE order_id = '".$orderID."'");
	$quantity = $quantityResult->fetch_array(MYSQLI_NUM);

	if($quantity[0] > 0) {
		echo "a";
	} else {
		if($mysqli->query("DELETE FROM orders_info WHERE id = '".$orderID."'")) {
			echo "b";
		}
	}
}