<?php

session_start();
include('../connect.php');
require_once("../recaptcha.php");

if(!empty($_POST['registrationLogin']) and strlen($_POST['registrationLogin']) >= 3) {
	if(!empty($_POST['registrationPassword'])) {
		if(!empty($_POST['registrationEmail']) and filter_var($_POST['registrationEmail'], FILTER_VALIDATE_EMAIL)) {
			if(!empty($_POST['registrationName'])) {
				if(!empty($_POST['registrationPhone'])) {
					$login = $mysqli->real_escape_string($_POST['registrationLogin']);
					$usersCountResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE login = '".$login."'");
					$usersCount = $usersCountResult->fetch_array(MYSQLI_NUM);

					if($usersCount[0] == 0) {
						$email = $mysqli->real_escape_string($_POST['registrationEmail']);
						$usersCountResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '".$email."'");
						$usersCount = $usersCountResult->fetch_array(MYSQLI_NUM);

						if($usersCount[0] == 0) {
							$phone = $mysqli->real_escape_string($_POST['registrationPhone']);
							$usersCountResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE phone = '".$phone."'");
							$usersCount = $usersCountResult->fetch_array(MYSQLI_NUM);

							if($usersCount[0] == 0) {
								$secret = "6Ld5MwATAAAAANoU2JPNZUfzMGWXg3-S-DxXTOuN";
								$response = null;
								$reCaptcha = new ReCaptcha($secret);

								if($_POST['g-recaptcha-response']) {
									$response = $reCaptcha->verifyResponse(
										$_SERVER["REMOTE_ADDR"],
										$_POST['g-recaptcha-response']
									);
								}

								if($response != null && $response->success) {
									$name = $mysqli->real_escape_string($_POST['registrationName']);

									if(!empty($_POST['registrationCompany'])) {
										$company = $mysqli->real_escape_string($_POST['registrationCompany']);
									} else {
										$company = "";
									}

									if(!empty($_POST['registrationPosition'])) {
										$position = $mysqli->real_escape_string($_POST['registrationPosition']);
									} else {
										$position = "";
									}

									$password = md5(md5($mysqli->real_escape_string($_POST['registrationPassword'])));
									$hash = md5($login.$password.$email.$company.$name.$position.$phone.date('YmdHis'));

									if($mysqli->query("INSERT INTO users (login, password, email, hash, company, name, position, phone, activated, registration_date, last_login, logins_count) VALUES ('".$login."', '".$password."', '".$email."', '".$hash."', '".$company."', '".$name."', '".$position."', '".$phone."', '0', '".date('d-m-Y H:i:s')."', '', '0')")) {
										sendMail($email, $hash);
										$_SESSION['registration'] = "ok";
										header("Location: ../../personal/success.php");
									} else {
										$_SESSION['registration'] = "false";
										$_SESSION['registrationLogin'] = $login;
										$_SESSION['registrationEmail'] = $email;
										$_SESSION['registrationCompany'] = $company;
										$_SESSION['registrationName'] = $name;
										$_SESSION['registrationPosition'] = $position;
										$_SESSION['registrationPhone'] = $phone;

										header("Location: ../../personal/register.php");
									}
								} else {
									$_SESSION['registration'] = "captcha";
									$_SESSION['registrationLogin'] = $login;
									$_SESSION['registrationEmail'] = $email;
									$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
									$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);
									$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
									$_SESSION['registrationPhone'] = $phone;

									header("Location: ../../personal/register.php");
								}
							} else {
								$_SESSION['registration'] = "phoneDuplicate";
								$_SESSION['registrationLogin'] = $login;
								$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
								$_SESSION['registrationEmail'] = $email;
								$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
								$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);

								header("Location: ../../personal/register.php");
							}
						} else {
							$_SESSION['registration'] = "emailDuplicate";
							$_SESSION['registrationLogin'] = $login;
							$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
							$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);
							$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
							$_SESSION['registrationPhone'] = $mysqli->real_escape_string($_POST['registrationPhone']);

							header("Location: ../../personal/register.php");
						}
					} else {
						$_SESSION['registration'] = "loginDuplicate";
						$_SESSION['registrationEmail'] = $mysqli->real_escape_string($_POST['registrationEmail']);
						$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
						$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);
						$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
						$_SESSION['registrationPhone'] = $mysqli->real_escape_string($_POST['registrationPhone']);

						header("Location: ../../personal/register.php");
					}
				} else {
					$_SESSION['registration'] = "phone";
					$_SESSION['registrationLogin'] = $mysqli->real_escape_string($_POST['registrationLogin']);
					$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
					$_SESSION['registrationEmail'] = $mysqli->real_escape_string($_POST['registrationEmail']);
					$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
					$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);

					header("Location: ../../personal/register.php");
				}
			} else {
				$_SESSION['registration'] = "name";
				$_SESSION['registrationLogin'] = $mysqli->real_escape_string($_POST['registrationLogin']);
				$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
				$_SESSION['registrationEmail'] = $mysqli->real_escape_string($_POST['registrationEmail']);
				$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
				$_SESSION['registrationPhone'] = $mysqli->real_escape_string($_POST['registrationPhone']);

				header("Location: ../../personal/register.php");
			}
		} else {
			$_SESSION['registration'] = "email";
			$_SESSION['registrationLogin'] = $mysqli->real_escape_string($_POST['registrationLogin']);
			$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
			$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);
			$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
			$_SESSION['registrationPhone'] = $mysqli->real_escape_string($_POST['registrationPhone']);

			header("Location: ../../personal/register.php");
		}
	} else {
		$_SESSION['registration'] = "password";
		$_SESSION['registrationLogin'] = $mysqli->real_escape_string($_POST['registrationLogin']);
		$_SESSION['registrationEmail'] = $mysqli->real_escape_string($_POST['registrationEmail']);
		$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
		$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);
		$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
		$_SESSION['registrationPhone'] = $mysqli->real_escape_string($_POST['registrationPhone']);

		header("Location: ../../personal/register.php");
	}
} else {
	$_SESSION['registration'] = "login";
	$_SESSION['registrationEmail'] = $mysqli->real_escape_string($_POST['registrationEmail']);
	$_SESSION['registrationCompany'] = $mysqli->real_escape_string($_POST['registrationCompany']);
	$_SESSION['registrationName'] = $mysqli->real_escape_string($_POST['registrationName']);
	$_SESSION['registrationPosition'] = $mysqli->real_escape_string($_POST['registrationPosition']);
	$_SESSION['registrationPhone'] = $mysqli->real_escape_string($_POST['registrationPhone']);

	header("Location: ../../personal/register.php");
}

function sendMail($address, $code) {
	$to = $address;

	$headers = "Content-type=text/html; charset: utf-8 \r\n";
	$headers .= "From: Администрация сайта Аргос-ФМ <no-reply@argos-fm.by>\r\n";

	$subject = "Регистрация на сайте Аргос-ФМ";
	$message = "Здравствуйте!<br /><br />Адрес вашей электронной почты был указан при регистрации на сайте <a href='http://argos-fm.by/'>argos-fm.by</a>. Для завершения регистрации перейдите, пожалуйста, по <a href='argos-fm.by/scripts/personal/confirm.php?hash='".$code."'>этой ссылке</a><br /><br />Если вы не регистрировались на сайте, а кто-то по ошибке или намеренно указал адрес вашей почты, перейдите по ссылке, чтобы <a href='argos-fm.by/scripts/personal/cancel.php?hash=".$code."'>аннулировать регистрацию</a>";

	mail($to, $subject, $message, $headers);
}