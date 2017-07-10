<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 10.07.2017
 * Time: 12:29
 */

session_start();
include('../connect.php');

$id = $mysqli->real_escape_string($_POST['order_id']);
$text = $mysqli->real_escape_string(nl2br($_POST['text']));

$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE id = '".$id."'");
$order = $orderResult->fetch_assoc();

$adminEmailResult = $mysqli->query("SELECT email FROM users WHERE id = '1'");
$adminEmail = $adminEmailResult->fetch_array(MYSQLI_NUM);

$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
$user = $userResult->fetch_assoc();

if($_SESSION['userID'] == $user['id']) {
	sendMailToAdmin($adminEmail[0], $user, $order, $text);
} else {
	sendMailToUser($user, $order, $text);
}

function sendMailToAdmin($adminEmail, $user, $order, $comment) {
	if(!empty($user['name']) and !empty($user['company'])) {
		$name = $user['company']." - ".$user['name'];
	} else {
		if(!empty($user['name']) and empty($user['company'])) {
			$name = $user['name'];
		}

		if(empty($user['name']) and !empty($user['company'])) {
			$name = $user['company'];
		}

		if(empty($user['name']) and empty($user['company'])) {
			$name = "";
		}
	}

	$from = $name."<".$user['email'].">";

	$reply = $user['email'];
	$subject = "Комментарий к заказу №".$order['id'];

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
					<p>К заказу №".$order['id']." был оставлен комментарий.</p>
					<p><b>Текст комментария: </b>".$comment."</p>
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

	mail($adminEmail, $subject, $message, $headers);
}

function sendMailToUser($user, $order, $comment) {
	$from = "ЧТУП Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Комментарий к заказу №".$order['id'];

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
					<p>К вашему заказу №".$order['id']." был оставлен комментарий.</p>
					<p><b>Текст комментария: </b>".$comment."</p>
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

	mail($user['email'], $subject, $message, $headers);
}