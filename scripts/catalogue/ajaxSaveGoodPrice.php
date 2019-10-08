<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../index.php");
}

include("../connect.php");

$price = $mysqli->real_escape_string($_POST['price']);
$goodID = $mysqli->real_escape_string($_POST['goodID']);

if($price >= 0) {
	if($mysqli->query("UPDATE catalogue_new SET price = '".$price."' WHERE id = '".$goodID."'")) {
		echo "a";
	} else {
		echo "b";
	}
} else {
	echo "b";
}