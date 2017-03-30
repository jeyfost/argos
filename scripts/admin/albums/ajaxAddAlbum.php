<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.03.2017
 * Time: 13:30
 */

include("../../connect.php");

$name = $mysqli->real_escape_string($_POST['name']);

$albumCheckResult = $mysqli->query("SELECT COUNT(id) FROM albums WHERE name = '".$name."'");
$albumCheck = $albumCheckResult->fetch_array(MYSQLI_NUM);

if($albumCheck[0] == 0) {
	if($mysqli->query("INSERT INTO albums (name) VALUES ('".$name."')")) {
		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "name";
}