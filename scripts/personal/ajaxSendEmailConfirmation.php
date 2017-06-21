<?php

session_start();
include("../connect.php");

$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
$user = $userResult->fetch_assoc();

$email = $mysqli->real_escape_string($_POST['email']);

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
	if($email != $user['email']) {
		$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '".$email."'");
		$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

		if($emailCheck[0] == 0) {
			if($mysqli->query("INSERT INTO email_old (user_id, email_prev, email_next, change_date, changed) VALUES ('".$_SESSION['userID']."', '".$user['email']."', '".$email."', '".date('d-m-Y H:i:s')."', '0')")) {
				$idResult = $mysqli->query("SELECT MAX(id) FROM email_old WHERE user_id = '".$_SESSION['userID']."'");
				$id = $idResult->fetch_array(MYSQLI_NUM);

				sendMail($email, $user['hash'], $id[0]);

				echo "a";
			} else {
				echo "b";
			}
		} else {
			echo "e";
		}
	} else {
		echo "d";
	}

} else {
	echo "c";
}

function sendMail($address, $code, $id) {
	$from = "Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Изменение адреса электронной почты на сайте Аргос-ФМ";

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
					<p>Здравствуйте!<br /><br />Адрес вашей электронной почты был указан при редактировании личных данных на сайте <a href='https://argos-fm.by/'>argos-fm.by</a>. Для завершения процедуры смены email-адреса перейдите, пожалуйста, по <a href='https://argos-fm.by/scripts/personal/email.php?hash=".$code."&id=".$id."'>этой ссылке</a><br /><br />Если вы не регистрировались на сайте, а кто-то по ошибке или намеренно указал адрес вашей почты, перейдите по ссылке, чтобы <a href='https://argos-fm.by/scripts/personal/emailCancel.php?hash=".$code."&id=".$id."'>аннулировать изменения</a></p>
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