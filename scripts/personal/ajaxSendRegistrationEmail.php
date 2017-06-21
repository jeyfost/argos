<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 21.06.2017
 * Time: 8:06
 */

include("../connect.php");

$email = $mysqli->real_escape_string($_POST['email']);
$code = $mysqli->real_escape_string($_POST['hash']);

$from = "Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>";
$reply = "no-reply@argos-fm.by";
$subject = "Регистрация на сайте Аргос-ФМ";

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
				<p>Здравствуйте!<br /><br />Адрес вашей электронной почты был указан при регистрации на сайте <a href='https://argos-fm.by/'>argos-fm.by</a>. Для завершения регистрации перейдите, пожалуйста, по <a href='https://argos-fm.by/scripts/personal/confirm.php?hash=".$code."'>этой ссылке</a><br /><br />Если вы не регистрировались на сайте, а кто-то по ошибке или намеренно указал адрес вашей почты, перейдите по ссылке, чтобы <a href='https://argos-fm.by/scripts/personal/cancel.php?hash=".$code."'>аннулировать регистрацию</a></p>
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

mail($email, $subject, $message, $headers);