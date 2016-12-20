<?php

session_start();
include("../connect.php");

$company = $mysqli->real_escape_string($_POST['company']);
$name = $mysqli->real_escape_string($_POST['name']);
$position = $mysqli->real_escape_string($_POST['position']);
$phone = $mysqli->real_escape_string($_POST['phone']);

if($mysqli->query("UPDATE users SET company = '".$company."', name = '".$name."', position = '".$position."', phone = '".$phone."' WHERE id = '".$_SESSION['userID']."'")) {
	echo "a";
} else {
	echo "b";
}