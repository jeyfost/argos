<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$login = $mysqli->real_escape_string($_POST['login']);
$email = $mysqli->real_escape_string($_POST['email']);
$password = $mysqli->real_escape_string($_POST['password']);
$company = $mysqli->real_escape_string($_POST['company']);
$name = $mysqli->real_escape_string($_POST['name']);
$position = $mysqli->real_escape_string($_POST['position']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$discount = $mysqli->real_escape_string($_POST['discount']);
$checkbox = $mysqli->real_escape_string($_POST['checkbox']);
$count = 0;
$error = 0;

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$id."'");
	$user = $userResult->fetch_assoc();

	if($user['email'] != $email) {
		$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '".$email."'");
		$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

		if($emailCheck[0] == 0) {
			if($mysqli->query("UPDATE users SET email = '".$email."' WHERE id = '".$id."'")) {
				if($mysqli->query("INSERT INTO email_old (user_id, email_prev, email_next, change_date, changed) VALUES ('".$id."', '".$user['email']."', '".$email."', '".date('d-m-Y H:i:s')."', '1')")) {
					$subject = "Ваш email-адрес был изменён";
					$message = "Здравствуйте!<br /><br />Ваш email-адрес на сайте <a href='https://argos-fm.by/'>argos-fm.by</a> был изменён на <b>".$email."</b>. С этого момента для авторизации используйте этот email или ваш логин.<br /><br />Размер вашей скидки и другая личная информация затронута не была.<br /><br />С наилучшими пожеланиями, команда Аргос-ФМ";
					$headers = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";
					mail($email, $subject, $message, $headers);
					$count++;
				}
				else {
					echo "emailFailed";
					$error++;
				}
			} else {
				echo "emailFailed";
				$error++;
			}
		} else {
			$error++;
			echo "emailDuplicate";
		}
	}

	if($user['login'] != $login) {
		$loginCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE login = '".$login."'");
		$loginCheck = $loginCheckResult->fetch_array(MYSQLI_NUM);

		if($loginCheck[0] == 0) {
			if($mysqli->query("UPDATE users SET login = '".$login."' WHERE id = '".$id."'")) {
				if($mysqli->query("INSERT INTO login_old (user_id, login_prev, login_next, change_date) VALUES ('".$id."', '".$user['login']."', '".$login."', '".date('d-m-Y H:i:s')."')")) {
					$subject = "Ваш логин был изменён";
					$message = "Здравствуйте!<br /><br />Ваш логин на сайте <a href='https://argos-fm.by/'>argos-fm.by</a> был изменён на <b>".$login."</b>. С этого момента для авторизации используйте этот логин или ваш email-адрес.<br /><br />Размер вашей скидки и другая личная информация затронута не была.<br /><br />С наилучшими пожеланиями, команда Аргос-ФМ";
					$headers = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";
					mail($email, $subject, $message, $headers);
					$count++;
				}
				else {
					echo "loginFailed";
					$error++;
				}
			} else {
				echo "loginFailed";
				$error++;
			}
		} else {
			echo "loginDuplicate";
			$error++;
		}
	}

	if($password != '') {
		$passwordNew = md5(md5($password));

		if($passwordNew != $user['password']) {
			if($mysqli->query("UPDATE users SET password = '".$passwordNew."' WHERE id = '".$id."'")) {
				if($mysqli->query("INSERT INTO password_old (user_id, password_prev, change_date) VALUES ('".$id."', '".$user['password']."', '".date('d-m-Y H:i:s')."')")) {
					$subject = "Ваш пароль был изменён";
					$message = "Здравствуйте!<br /><br />Ваш пароль на сайте <a href='https://argos-fm.by/'>argos-fm.by</a> был изменён на <b>".$password."</b>. С этого момента для авторизации используйте новый пароль.<br /><br />С наилучшими пожеланиями, команда Аргос-ФМ";
					$headers = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";
					mail($email, $subject, $message, $headers);
					$count++;
				} else {
					echo "passwordFailed";
					$error++;
				}
			} else {
				echo "passwordFailed";
				$error++;
			}
		}
	}

	if($mysqli->query("UPDATE users SET company = '".$company."', name = '".$name."', position = '".$position."', phone = '".$phone."', discount = '".$discount."', opt = '".$checkbox."' WHERE id = '".$id."'")) {
		$count++;
	} else {
		echo "failed";
		$error++;
	}

	if($error == 0) {
		if($count > 0) {
			echo "ok";
		} else {
			echo "no";
		}
	}
} else {
	echo "email";
}