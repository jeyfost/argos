<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 15:53
 */

include("../../connect.php");

$req = false;
ob_start();

$filesErrors = 0;
$filesCount = 0;
$fileNames = "";

if(!empty($_FILES['attachment']['tmp_name'][0])) {
	for($i = 0; $i < count($_FILES['attachment']['name']); $i++) {
		if(empty($_FILES['attachment']['tmp_name'][$i]) or $_FILES['attachment']['error'][$i] != 0) {
			$filesErrors++;
		} else {
			if($i > 0) {
				$fileNames .= "; ";
			}

			$fileNames .= $_FILES['attachment']['name'][$i];
			$filesCount++;
		}
	}
}

if($filesErrors == 0) {
	$location = $mysqli->real_escape_string($_POST['district']);
	$from = "ЧТУП Аргос-ФМ <argos-fm@mail.ru>";
	$subject = $mysqli->real_escape_string($_POST['subject']);
	$reply = "argos-fm@mail.ru";
	$text = $_POST['text'];
	$p = $mysqli->real_escape_string($_POST['parameter']);

	$hash = md5(date('r', time()));

	$headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
	$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

	$message = "--PHP-mixed-".$hash."\n";
	$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	$message .= $text."\n";
	$message .= "--PHP-mixed-".$hash."\n";

	if(!empty($_FILES['attachment']['tmp_name'][0])) {
		for($i = 0; $i < count($_FILES['attachment']['name']); $i++) {
			$attachment = chunk_split(base64_encode(file_get_contents($_FILES['attachment']['tmp_name'][$i])));

			$message .= "Content-Type: application/octet-stream; name=".$_FILES['attachment']['name'][$i]."\n";
			$message .= "Content-Transfer-Encoding: base64\n";
			$message .= "Content-Disposition: attachment\n\n";
			$message .= $attachment."\n";
			$message .= "--PHP-mixed-".$hash."\n";
		}
	}

	$baseMessage = $message;
	$mailCount = 0;
	$mailSuccessCount = 0;
	$c = "";
	$start = $p * 10 + 1;

	$clientResult = $mysqli->query("SELECT * FROM clients WHERE location = '".$location."' AND in_send = '1' LIMIT ".$start.", 10");
	while($client = $clientResult->fetch_assoc()) {
		$fullMessage = $baseMessage."--PHP-mixed-".$hash."\n\n"."--------------------\n\nВесь ассортимент продукции можно посмотреть на нашем сайте: www.argos-fm.by\nА также уточнить наличие по телефону: +375 (222) 707-707 или посетить нас по адресу: Республика Беларусь, г. Могилёв, ул. Залуцкого, д.21\n\nМы всегда рады сотрудничеству с Вами!\n\nЕсли вы не хотите в дальнейшем получать эту рассылку, вы можете отписаться, перейдя по <a href='http://argos-fm.by/test/scripts/admin/email/stop.php?hash=".$client['hash']."' target='_blank'>это ссылке</a>.\n";
		$mailCount++;

		if(mail($client['email'], $subject, $fullMessage, $headers)) {
			$mailSuccessCount++;
			$c .= $client['id'].";";
		}
	}

	$c = substr($c, 0, strlen($c) - 1);

	$mysqli->query("INSERT INTO mail_result (subject, text, send_to, date, count, send, files_count, filenames) VALUES ('".$subject."', '".$text."', 'district ".$location.": ".$c."', '".date('Y-m-d H:i:s')."', '".$mailCount."', '".$mailSuccessCount."', '".$filesCount."', '".$fileNames."')");

	if($mailSuccessCount > 0) {
		if($mailSuccessCount == $mailCount) {
			echo "ok";
		} else {
			echo "partly";
		}
	} else {
		echo "failed";
	}
} else {
	echo "files";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;