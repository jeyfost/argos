<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$values = explode(';', $_POST['values']);
$ids = explode(',', $_POST['ids']);
$count = 0;
$check = 0;

for($i = 0; $i < count($values); $i++) {
	if($values[$i] <= 0) {
		$check++;
	}
}

if($check == 0) {
	for($i = 0; $i < count($ids); $i++) {
		if($mysqli->query("UPDATE currency SET rate = '".$values[$i]."' WHERE id = '".$ids[$i]."'")) {
			$count++;
		}
	}

	if($count > 0) {
		if($count == count($ids)) {
			echo "a";
		} else {
			echo "b";
		}
	} else {
		echo "d";
	}
} else {
	echo "c";
}