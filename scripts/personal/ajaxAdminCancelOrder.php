<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("DELETE FROM orders_info WHERE id = '".$id."'")) {
	if($mysqli->query("DELETE FROM orders WHERE order_id = '".$id."'")) {
		echo "a";
	} else {
		echo "b";
	}
} else {
	echo "b";
}