<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

$idResult = $mysqli->query("SELECT MAX(id) FROM orders_info");
$id = $idResult->fetch_array(MYSQLI_NUM);
$id = $id[0] + 1;

$basketResult = $mysqli->query("SELECT * FROM basket WHERE user_id = '".$_SESSION['userID']."'");
while($basket = $basketResult->fetch_assoc()) {
	$mysqli->query("INSERT INTO orders (order_id, user_id, good_id, quantity) VALUES (".$id.", ".$_SESSION['userID'].", ".$basket['good_id'].", ".$basket['quantity'].")");
}

if($mysqli->query("INSERT INTO orders_info (id, user_id, summ, send_date, proceed_date, status) VALUES ('".$id."', '".$_SESSION['userID']."', '0', '".date('d-m-Y H:i:s')."', '', '0')")) {
	if($mysqli->query("DELETE FROM basket WHERE user_id = '".$_SESSION['userID']."'")) {
		echo "a";
	} else {
		echo "b";
	}
} else {
	echo "b";
}