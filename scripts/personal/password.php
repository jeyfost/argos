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
	$from = "Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Смена пароля на сайте Аргос-ФМ";

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
					<p>Ваш пароль был успешно изменён. Ваш новый пароль: <b>".$password."</b></p>
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