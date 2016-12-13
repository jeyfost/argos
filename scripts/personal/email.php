<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

if(empty($_REQUEST['hash']) or empty($_REQUEST['id'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

$hash = $mysqli->real_escape_string($_REQUEST['hash']);
$id = $mysqli->real_escape_string($_REQUEST['id']);

$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
$user = $userResult->fetch_assoc();

if($hash != $user['hash']) {
	header("Location: ../../index.php");
} else {
	if($mysqli->query("UPDATE email_old SET changed = '1' WHERE id = '".$id."'")) {
		$emailResult = $mysqli->query("SELECT email_next FROM email_old WHERE id = '".$id."'");
		$email = $emailResult->fetch_array(MYSQLI_NUM);

		if($mysqli->query("UPDATE users SET email = '".$email[0]."' WHERE id = '".$_SESSION['userID']."'")) {
			$mysqli->query("DELETE FROM email_old WHERE user_id = '".$_SESSION['userID']."' AND changed = '0'");
			$_SESSION['editEmail'] = "ok";
			header("Location: ../../personal/personal.php?section=2");
		} else {
			$_SESSION['editEmail'] = "failed";
			header("Location: ../../personal/personal.php?section=2");
		}
	}
}