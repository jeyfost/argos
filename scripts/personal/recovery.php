<?php

session_start();
include("../connect.php");

if(!empty($_POST['recoveryLogin'])) {
	$login = $mysqli->real_escape_string($_POST['recoveryLogin']);
	$userResult = $mysqli->query("SELECT * FROM users WHERE login = '".$login."' OR email = '".$login."'");
	if($userResult->num_rows > 0) {
		$user = $userResult->fetch_assoc();
		sendMail($user['email'], $user['hash']);
		$_SESSION['recovery'] = "ok";
		header("Location: ../../personal/password.php");
	} else {
		$_SESSION['recovery'] = "failed";
		header("Location: ../../personal/recovery.php");
	}
} else {
	$_SESSION['recovery'] = "empty";
	header("Location: ../../personal/recovery.php");
}

function sendMail($address, $hash) {
	$to = $address;

	$subject = "Восстановление пароля на сайте Аргос-ФМ";
	$message = "Здравствуйте!<br /><br />От вашего имени поступил запрос на изменение пароля на сайте <a href='http://argos-fm.by/'>argos-fm.by</a>.<br /><br />Для изменения пароля перейдите по следующей ссылке: <a href='http://argos-fm.by/scripts/personal/recovery.php?hash=".$hash."'>изменить ваш пароль</a>.<br /><br />Если вы не отправляли запрос на изменение пароля, то удалите это письмо.";

	$headers = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";

	mail($to, $subject, $message, $headers);
}