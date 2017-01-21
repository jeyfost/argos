<?php

session_start();
include("../connect.php");

if(!empty($_POST['lastName']) and !empty($_POST['firstName']) and !empty($_POST['patronymic']) and !empty($_POST['city']) and !empty($_POST['phone']) and !empty($_POST['email']) and !empty($_POST['text'])) {
	if(!empty($_FILES['CV']['name']) and $_FILES['CV']['error'] == 0) {
		$lastName = $mysqli->real_escape_string($_POST['lastName']);
		$fistName = $mysqli->real_escape_string($_POST['firstName']);
		$patronymic = $mysqli->real_escape_string($_POST['patronymic']);
		$city = $mysqli->real_escape_string($_POST['city']);
		$phone = $mysqli->real_escape_string($_POST['phone']);
		$email = $mysqli->real_escape_string($_POST['email']);
		$text = $mysqli->real_escape_string($_POST['text']);
		$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

		$hash = md5(date('r', time()));

		$to = "argos-fm@mail.ru";
		$reply = "no-reply@argos-fm.by";
		$subject = "Резюме с сайта Аргос-ФМ";

		$headers = "Content-type=text/html; charset: utf-8 \r\n";
		$headers .= "From: Сайт Аргос-ФМ <no-reply@argos-fm.by>\r\n";
		$message = "--PHP-mixed-".$hash."\n";
		$message .= "<b>Фамилия: </b>".$lastName."<br /><br /><b>Имя: </b>".$fistName."<br /><br /><b>Отчество: </b>".$patronymic."<br /><br /><b>Дата рождения: </b>".$_POST['day']." ".$_POST['month']." ".$_POST['year']." г.<br /><br /><b>Город проживания: </b>".$city."<br /><br /><b>Контактный телефон: </b>".$phone."<br /><br /><b>Email: </b>".$email."<br /><br /><b>Интересующие вакансии или другой текст: </b>".$text;
		$message .= "--PHP-mixed-".$hash."\n";

		$attachment = chunk_split(base64_encode(file_get_contents($_FILES['CV']['tmp_name'])));
		$message .= "Content-Type: application/octet-stream; name=".$_FILES['CV']['name']."\n";
		$message .= "Content-Transfer-Encoding: base64\n";
		$message .= "Content-Disposition: attachment\n\n";
		$message .= $attachment."\n";
		$message .= "--PHP-mixed-".$hash."\n";

		if(@mail($to, $subject, $message, $headers)) {
			$_SESSION['error'] = "success";

			header("Location: ../../about/vacancies.php");
		} else {
			$_SESSION['error'] = "failed";
			$_SESSION['lastName'] = $_POST['lastName'];
			$_SESSION['firstName'] = $_POST['firstName'];
			$_SESSION['patronymic'] = $_POST['patronymic'];
			$_SESSION['city'] = $_POST['city'];
			$_SESSION['phone'] = $_POST['phone'];
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['text'] = $_POST['text'];

			header("Location: ../../about/vacancies.php");
		}
	} else {
		$_SESSION['error'] = "file";
		$_SESSION['lastName'] = $_POST['lastName'];
		$_SESSION['firstName'] = $_POST['firstName'];
		$_SESSION['patronymic'] = $_POST['patronymic'];
		$_SESSION['city'] = $_POST['city'];
		$_SESSION['phone'] = $_POST['phone'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['text'] = $_POST['text'];

		header("Location: ../../about/vacancies.php");
	}
} else {
	$_SESSION['error'] = "empty";
	$_SESSION['lastName'] = $_POST['lastName'];
	$_SESSION['firstName'] = $_POST['firstName'];
	$_SESSION['patronymic'] = $_POST['patronymic'];
	$_SESSION['city'] = $_POST['city'];
	$_SESSION['phone'] = $_POST['phone'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['text'] = $_POST['text'];

	header("Location: ../../about/vacancies.php");
}