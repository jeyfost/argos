<?php

include("../../connect.php");

$found = 0;
$index = 1;
$code = "";

do {
	switch(strlen($index)) {
		case 1:
			$code = "000".$index;
			break;
		case 2:
			$code = "00".$index;
			break;
		case 3:
			$code = "0".$index;
			break;
		default:
			$code = $index;
			break;
	}

	$index++;

	$goodCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE code = '".$code."'");
	$goodCount = $goodCountResult->fetch_array(MYSQLI_NUM);

	if($goodCount[0] == 0) {
		$found = 1;
	}
} while ($found == 0);

echo $code;