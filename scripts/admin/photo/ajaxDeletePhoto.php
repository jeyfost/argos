<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.03.2017
 * Time: 12:53
 */

include("../../connect.php");

$photoCheckResult = $mysqli->query("SELECT COUNT(id) FROM photos WHERE id = '".$_POST['id']."'");
$photoCheck = $photoCheckResult->fetch_array(MYSQLI_NUM);

if($photoCheck[0] != 0) {
	$photoResult = $mysqli->query("SELECT * FROM photos WHERE id = '".$_POST['id']."'");
	$photo = $photoResult->fetch_assoc();

	if($mysqli->query("DELETE FROM photos WHERE id = '".$_POST['id']."'")) {
		unlink("../../../img/photos/gallery/big/".$photo['photo_big']);
		unlink("../../../img/photos/gallery/small/".$photo['photo_small']);

		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "photo";
}