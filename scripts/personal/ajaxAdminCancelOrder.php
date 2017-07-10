<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$userResult = $mysqli->query("SELECT * FROM users WHERE id = (SELECT user_id FROM orders_info WHERE id = '".$id."')");
$user = $userResult->fetch_assoc();

$adminResult = $mysqli->query("SELECT * FROM users WHERE id = '1'");
$admin = $adminResult->fetch_assoc();

if($mysqli->query("DELETE FROM orders_info WHERE id = '".$id."'")) {
	if($mysqli->query("DELETE FROM orders WHERE order_id = '".$id."'")) {
		sendMail($user['email'], $id, $admin);

		echo "a";
	} else {
		echo "b";
	}
} else {
	echo "b";
}

function sendMail($email, $id, $admin) {
	$from = "ЧТУП Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Заказ №".$id." был отклонён";

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
					<p>Ваш заказ №".$id." был отклонён. Для уточнения деталей свяжитесь с нами по телефону ".$admin['phone']." или отправьте письмо по адресу <a href='mailto:".$admin['email']."' style='color: #df4e47;'>".$admin['email']."</a>.</p>
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

	return true;
}