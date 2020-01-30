<?php

include("../connect.php");

$name = $mysqli->real_escape_string($_POST['name']);
$email = $mysqli->real_escape_string($_POST['email']);
$subject = $mysqli->real_escape_string($_POST['subject']) . " | Сообщение с сайта Аргос-ФМ";
$text = $mysqli->real_escape_string($_POST['message']);

$to = CONTACT_EMAIL;
$from = $name . "<" . $email . ">";
$reply = $email;

$hash = md5(rand(0, 1000000) . date('Y-m-d H:i:s'));

$headers = "From: " . $from . "\nReply-To: " . $reply . "\nMIME-Version: 1.0";
$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-" . $hash . "\"\n\n";

$message = "--PHP-mixed-" . $hash . "\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";

$message .= "
				<div style='width: 100%; height: 100%; background-color: #fafafa; padding-top: 5px; padding-bottom: 20px;'>
					<center>
						<div style='width: 600px; text-align: left;'>
							<a href='https://argos-fm.by/' target='_blank'><img src='https://argos-fm.by/pictures/system/logo.png' /></a>
						</div>
						<br />
						<div style='padding: 20px; box-shadow: 0 5px 15px -4px rgba(0, 0, 0, 0.4); background-color: #fff; width: 600px; text-align: left;'>
							<b>Имя: </b>" . $name . "
							<br />
							<b>Email: </b>" . $email . "
							<br /><br />
							<b>Текст письма: </b>" . $text . "													
							<div style='width: 100%; height: 10px;'></div>
						</div>
						<br /><br />
					</center>
				</div>
			";

if($mysqli->query("INSERT INTO messages (name, email, text) VALUES ('".$name."', '".$email."', '".$text."')")) {
    if (@mail($to, $subject, $message, $headers)) {
        echo "a";
    } else {
        echo "b";
    }
} else {
    echo "b";
}