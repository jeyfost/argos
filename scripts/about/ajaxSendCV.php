<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 22.06.2017
 * Time: 10:27
 */

include("../connect.php");

$req = false;
ob_start();

if(!empty($_FILES['CV']['tmp_name']) and $_FILES['CV']['error'] == 0) {
	$captcha = "";

	if(isset($_POST["g-recaptcha-response"])) {
		$captcha = $_POST["g-recaptcha-response"];
	}

	$secret = "6Ld5MwATAAAAANoU2JPNZUfzMGWXg3-S-DxXTOuN";
	$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);

	if ($response["success"] != false) {
			$lastName = $mysqli->real_escape_string($_POST['lastName']);
			$fistName = $mysqli->real_escape_string($_POST['firstName']);
			$patronymic = $mysqli->real_escape_string($_POST['patronymic']);
			$city = $mysqli->real_escape_string($_POST['city']);
			$phone = $mysqli->real_escape_string($_POST['phone']);
			$email = $mysqli->real_escape_string($_POST['email']);
			$text = $mysqli->real_escape_string($_POST['text']);
			$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

			$to = "argos-fm@mail.ru";
			$from = "Сайт Аргос-ФМ <no-reply@argos-fm.by>";
			$reply = "no-reply@argos-fm.by";
			$subject = "Резюме с сайта Аргос-ФМ";

			$hash = md5(rand(0, 1000000).date('Y-m-d H:i:s'));

			$headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
			$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

			$message = "--PHP-mixed-".$hash."\n";
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
							<b>Фамилия: </b>".$lastName."
							<br />
							<b>Имя: </b>".$fistName."
							<br />
							<b>Отчество: </b>".$patronymic."
							<br />
							<b>Дата рождения: </b>".$_POST['day']." ".$month[$_POST['month']]." ".$_POST['year']." г.
							<br />
							<b>Город проживания: </b>".$city."
							<br />
							<b>Контактный телефон: </b>".$phone."
							<br />
							<b>Email: </b>".$email."
							<br />
							<b>Интересующие вакансии или другой текст: </b>".$text."
							<br /><hr /><br />
							<p style='font-size: 12px;'>Это автоматическая рассылка. Отвечать на неё не нужно.</p>
							<div style='width: 100%; height: 10px;'></div>
						</div>
						<br /><br />
					</center>
				</div>
			";

			$message .= "--PHP-mixed-".$hash."\n";

			$attachment = chunk_split(base64_encode(file_get_contents($_FILES['CV']['tmp_name'])));

			$message .= "Content-Type: application/octet-stream; name=".$_FILES['CV']['name']."\n";
			$message .= "Content-Transfer-Encoding: base64\n";
			$message .= "Content-Disposition: attachment\n\n";
			$message .= $attachment."\n";
			$message .= "--PHP-mixed-".$hash."\n";

			if(@mail($to, $subject, $message, $headers)) {
				echo "ok";
			} else {
				echo "failed";
			}
	} else {
		echo "captcha";
	}
} else {
	echo "file";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;