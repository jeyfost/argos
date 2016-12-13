<?php

session_start();
include("../connect.php");

$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
$user = $userResult->fetch_assoc();

$email = $mysqli->real_escape_string($_POST['email']);

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
	if($email != $user['email']) {
		if($mysqli->query("INSERT INTO email_old (user_id, email_prev, email_next, change_date, changed) VALUES ('".$_SESSION['userID']."', '".$user['email']."', '".$email."', '".date('d-m-Y H:i:s')."', '0')")) {
			$idResult = $mysqli->query("SELECT MAX(id) FROM email_old WHERE user_id = '".$_SESSION['userID']."'");
			$id = $idResult->fetch_array(MYSQLI_NUM);

			sendMail($email, $user['hash'], $id[0]);

			echo "a";
		} else {
			echo "b";
		}
	} else {
		echo "d";
	}

} else {
	echo "c";
}

function sendMail($address, $code, $id) {
	$to = $address;

	$headers = "Content-type=text/html; charset: utf-8 \r\n";
	$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";

	$subject = "Изменение адреса на сайте Аргос-ФМ";
	$message = "Здравствуйте!<br /><br />Адрес вашей электронной почты был указан при редактировании личных данных на сайте <a href='http://argos-fm.by/'>argos-fm.by</a>. Для завершения процедуры смены email-адреса перейдите, пожалуйста, по <a href='http://argos-fm.by/scripts/personal/email.php?hash=".$code."&id=".$id."'>этой ссылке</a><br /><br />Если вы не регистрировались на сайте, а кто-то по ошибке или намеренно указал адрес вашей почты, перейдите по ссылке, чтобы <a href='http://argos-fm.by/scripts/personal/emailCancel.php?hash=".$code."&id=".$id."'>аннулировать изменения</a>";

	mail($to, $subject, $message, $headers);
}