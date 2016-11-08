<?php

session_start();
include('../connect.php');

$login = $mysqli->real_escape_string($_POST['loginLogin']);

$userIDResult = $mysqli->query("SELECT id FROM users WHERE login = '".$login."' OR email = '".$login."'");
$userID = $userIDResult->fetch_array(MYSQLI_NUM);

if($userID[0] > 0) {
	$passwordResult = $mysqli->query("SELECT password FROM users WHERE id = '".$userID[0]."'");
	$password = $passwordResult->fetch_array(MYSQLI_NUM);

	if(md5(md5($_POST['loginPassword'])) == $password[0]) {
		$_SESSION['userID'] = $userID[0];
		$referer = $_SESSION['referer'];
		unset($_SESSION['referer']);
		setcookie("argosfm_login", $login, time()+60*60*24*30*12, '/');
		setcookie("argosfm_password", $password[0], time()+60*60*24*30*12, '/');

		$loginsCountResult = $mysqli->query("SELECT logins_count FROM users WHERE id = '".$userID[0]."'");
		$loginsCount = $loginsCountResult->fetch_array(MYSQLI_NUM);
		$count = $loginsCount[0] + 1;

		$mysqli->query("UPDATE users SET last_login = '".date('d-m-Y H:i:s')."', logins_count = '".$count."' WHERE id = '".$userID[0]."'");

		header("Location: ".$referer);
	} else {
		$_SESSION['loginError'] = 1;
		header("Location: ../../personal/login.php");
	}
} else {
	$_SESSION['loginError'] = 1;
	header("Location: ../../personal/login.php");
}
