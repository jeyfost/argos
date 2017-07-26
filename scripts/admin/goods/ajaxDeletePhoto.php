<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.07.2017
 * Time: 9:09
 */

include("../../connect.php");

$photoID = $mysqli->real_escape_string($_POST['photo_id']);
$goodID = $mysqli->real_escape_string($_POST['good_id']);

$photoCheckResult = $mysqli->query("SELECT COUNT(id) FROM goods_photos WHERE id = '".$photoID."' AND good_id = '".$goodID."'");
$photoCheck = $photoCheckResult->fetch_array(MYSQLI_NUM);

if($photoCheck[0] > 0) {
	$photoResult = $mysqli->query("SELECT * FROM goods_photos WHERE id = '".$photoID."'");
	$photo = $photoResult->fetch_assoc();

	if($mysqli->query("DELETE FROM goods_photos WHERE id = '".$photoID."'")) {
		unlink("../../../img/catalogue/photos/big/".$photo['big']);
		unlink("../../../img/catalogue/photos/small/".$photo['small']);

		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "id";
}