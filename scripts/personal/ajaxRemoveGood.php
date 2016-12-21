<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("DELETE FROM basket WHERE user_id = '".$_SESSION['userID']."' AND good_id = '".$id."'")) {
	echo "a";
} else {
	echo "b";
}