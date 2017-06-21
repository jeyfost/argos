<?php

session_start();

include("../connect.php");

if(!empty($_POST['recoveryPassword'])) {
	$password = md5(md5($mysqli->real_escape_string($_POST['recoveryPassword'])));

	$userResult = $mysqli->query("SELECT * FROM users WHERE hash = '".$_SESSION['hash']."'");
	$user = $userResult->fetch_assoc();

	$mysqli->query("INSERT INTO password_old (user_id, password_prev, change_date) VALUES ('".$user['id']."', '".$user['password']."', '".date('d-m-Y H:i:s')."')");

	if($mysqli->query("UPDATE users SET password = '".$password."' WHERE hash = '".$_SESSION['hash']."'")) {
		$emailResult = $mysqli->query("SELECT email FROM users WHERE hash = '".$_SESSION['hash']."'");
		$email = $emailResult->fetch_array(MYSQLI_NUM);

		sendMail($email[0], $mysqli->real_escape_string($_POST['recoveryPassword']));

		$_SESSION['recoveryPassword'] = "ok";
		unset($_SESSION['hash']);
		header("Location: ../../personal/newPassword.php");
	} else {
		$_SESSION['recoveryPassword'] = "failed";
		header("Location: ../../personal/password.php?hash=".$_SESSION['hash']);
	}
} else {
	$_SESSION['recoveryPassword'] = "empty";
	header("Location: ../../personal/password.php?hash=".$_SESSION['hash']);
}

function sendMail($address, $password) {
	$to = $address;

	$subject = "Смена пароля на сайте Аргос-ФМ";
	$message = "Здравствуйте!<br /><br />Ваш пароль был успешно изменён. Ваш новый пароль: <b>".$password."</b>";

	$headers = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";

	mail($to, $subject, $message, $headers);
}