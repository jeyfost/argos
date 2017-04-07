<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 07.04.2017
 * Time: 11:35
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$clientCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE id = '".$id."'");
$clientCheck = $clientCheckResult->fetch_array(MYSQLI_NUM);

if($clientCheck[0] > 0) {
	if($mysqli->query("UPDATE clients SET in_send = '1', disactivation_date = '0000-00-00 00:00:00:' WHERE id = '".$id."'")) {
		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "client";
}