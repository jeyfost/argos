<?php

session_start();
include("../connect.php");

$password = $mysqli->real_escape_string($_POST['password']);
$passwordConfirm = $mysqli->real_escape_string($_POST['passwordConfirm']);

if($password != $passwordConfirm) {
	echo "c";
} else {
	$passwordOldResult = $mysqli->query("SELECT password FROM users WHERE id = '".$_SESSION['userID']."'");
	$passwordOld = $passwordOldResult->fetch_array(MYSQLI_NUM);

	if($passwordOld[0] == md5(md5($password))) {
		echo "d";
	} else {
		if($mysqli->query("UPDATE users SET password = '".md5(md5($password))."' WHERE id = '".$_SESSION['userID']."'")) {
			$mysqli->query("INSERT INTO password_old (user_id, password_prev, change_date) VALUES ('".$_SESSION['id']."', '".$passwordOld[0]."', '".date('d-m-Y H:i:s')."')");
			echo "a";
		} else {
			echo "b";
		}
	}
}