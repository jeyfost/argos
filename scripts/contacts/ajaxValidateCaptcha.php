<?php

$captcha = "";
if(isset($_POST["g-recaptcha-response"])) {
	$captcha = $_POST["g-recaptcha-response"];
}

if(!$captcha) {
	echo "b";
}

$secret = "6Ld5MwATAAAAANoU2JPNZUfzMGWXg3-S-DxXTOuN";
$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);

if ($response["success"] != false) {
	echo "a";
} else {
	echo "b";
}