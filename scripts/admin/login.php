<?php

session_start();
include("../connect.php");

$login = $mysqli->real_escape_string($_POST['login']);
$password = $mysqli->real_escape_string($_POST['password']);

$IDResult = $mysqli->query("SELECT id FROM users WHERE login = '".$login."' AND password = '".md5(md5($password))."'");
$ID = $IDResult->fetch_array(MYSQLI_NUM);

if($ID[0] == 1) {
	$_SESSION['userID'] = $ID[0];
	header("Location: ../../admin/admin.php");
} else {
	$_SESSION['loginError'] = "error";
	header("Location: ../../admin/");
}