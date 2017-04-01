<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 01.04.2017
 * Time: 20:34
 */

include("../../connect.php");

$position = $mysqli->real_escape_string($_POST['position']);

$vacancyCheckResult = $mysqli->query("SELECT COUNT(id) FROM vacancies WHERE position = '".$position."' AND opened = '1'");
$vacancyCheck = $vacancyCheckResult->fetch_array(MYSQLI_NUM);

if($vacancyCheck[0] == 0) {
	if($mysqli->query("INSERT INTO vacancies (position, text, created, opened) VALUES ('".$position."', '".$_POST['text']."', '".date("d-m-Y")."', '1')")) {
		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "duplicate";
}