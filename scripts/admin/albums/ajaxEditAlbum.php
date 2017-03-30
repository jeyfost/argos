<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.03.2017
 * Time: 14:39
 */

include("../../connect.php");

$req = false;
ob_start();

$name = $mysqli->real_escape_string($_POST['name']);

$albumCheckResult = $mysqli->query("SELECT COUNT(id) FROM albums WHERE name = '".$name."' AND id <> '".$_POST['album']."'");
$albumCheck = $albumCheckResult->fetch_array(MYSQLI_NUM);

if($albumCheck[0] == 0) {
	if($mysqli->query("UPDATE albums SET name = '".$name."' WHERE id = '".$_POST['album']."'")) {
		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "name";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;