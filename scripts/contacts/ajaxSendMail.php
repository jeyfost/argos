<?php

include("../connect.php");

$from = $mysqli->real_escape_string($_POST['name']);
$email = $mysqli->real_escape_string($_POST['email']);
$subject = $mysqli->real_escape_string($_POST['subject'])." | Сообщение с сайта Аргос-ФМ";
$to = "foster_andrew@tut.by";
$text = $mysqli->real_escape_string($_POST['message']);
$hash = md5(date('r', time()));
$headers = "From: ".$from."\nReply-To: ".$email."\nMIME-Version: 1.0";
$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";
$message = "--PHP-mixed-".$hash."\n";
$message .= "Content-Type: text/html; charset=\"utf8\"\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";
$message .= $text."\n";
$message .= "--PHP-mixed-".$hash."\n";

if(@mail($to, $subject, $message, $headers)) {
	echo "a";
} else {
	echo "b";
}