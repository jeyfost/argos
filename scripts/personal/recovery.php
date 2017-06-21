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

function sendMail($address, $code) {
	$from = "Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Восстановление пароля на сайте Аргос-ФМ";

	$hash = md5(rand(0, 1000000).date('Y-m-d H:i:s'));

	$headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
	$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

	$text = "
		<div style='width: 100%; height: 100%; background-color: #fafafa; padding-top: 5px; padding-bottom: 20px;'>
			<center>
				<div style='width: 600px; text-align: left;'>
					<a href='https://argos-fm.by/' target='_blank'><img src='https://argos-fm.by/pictures/system/logo.png' /></a>
				</div>
				<br />
				<div style='padding: 20px; box-shadow: 0 5px 15px -4px rgba(0, 0, 0, 0.4); background-color: #fff; width: 600px; text-align: left;'>
					<p>Здравствуйте!<br /><br />От вашего имени поступил запрос на изменение пароля на сайте <a href='https://argos-fm.by/'>argos-fm.by</a>.<br /><br />Для изменения пароля перейдите по следующей ссылке: <a href='https://argos-fm.by/personal/password.php?hash=".$code."'>изменить ваш пароль</a>.<br /><br />Если вы не отправляли запрос на изменение пароля, то удалите это письмо.</p>
					<br /><hr /><br />
					<p style='font-size: 12px;'>Это автоматическая рассылка. Отвечать на неё не нужно.</p>
					<div style='width: 100%; height: 10px;'></div>
				</div>
				<br /><br />
			</center>
		</div>
	";

	$message = "--PHP-mixed-".$hash."\n";
	$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	$message .= $text."\n";
	$message .= "--PHP-mixed-".$hash."\n";

	mail($address, $subject, $message, $headers);
}