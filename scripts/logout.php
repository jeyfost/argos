<?php

session_start();

if(!empty($_SESSION['userID']))  {
	unset($_SESSION['userID']);
	setcookie("argosfm_login", "", 0, '/');
	setcookie("argosfm_password", "", 0, '/');
	header("Location: ".$_SERVER['HTTP_REFERER']);
}