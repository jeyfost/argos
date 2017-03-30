<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.03.2017
 * Time: 14:50
 */

include("../../connect.php");

$req = false;
ob_start();

$photoCheckResult = $mysqli->query("SELECT COUNT(id) FROM photos WHERE album = '".$_POST['album']."'");
$photoCheck = $photoCheckResult->fetch_array(MYSQLI_NUM);

$deleted = 0;

if($photoCheck[0] > 0) {
	$photoResult = $mysqli->query("SELECT * FROM photos WHERE album = '".$_POST['album']."'");
	while($photo = $photoResult->fetch_assoc()) {
		if($mysqli->query("DELETE FROM photos WHERE id = '".$photo['id']."'")) {
			unlink("../../../img/photos/gallery/big/".$photo['photo_big']);
			unlink("../../../img/photos/gallery/small/".$photo['photo_small']);

			$deleted++;
		}
	}
}

if($mysqli->query("DELETE FROM albums WHERE id = '".$_POST['album']."'")) {
	if($photoCheck[0] > 0) {
		if($deleted == $photoCheck[0]) {
			echo "ok";
		} else {
			echo "photos";
		}
	} else {
		echo "ok";
	}
} else {
	if($photoCheck[0] > 0) {
		if($deleted == $photoCheck[0]) {
			echo "failedPhotosOk";
		} else {
			echo "failed";
		}
	} else {
		echo "failed";
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;