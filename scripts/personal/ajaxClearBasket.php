<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

if($mysqli->query("DELETE FROM basket WHERE user_id = '".$_SESSION['userID']."'")) {
	echo "a";
} else {
	echo "b";
}