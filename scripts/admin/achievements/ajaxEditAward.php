<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 31.03.2017
 * Time: 13:10
 */

include("../../connect.php");
include("../../simpleImage.php");

function randomName($tmp_name) {
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

$req = false;
ob_start();

$name = $mysqli->real_escape_string($_POST['name']);
$id = $mysqli->real_escape_string($_POST['award']);

if(!empty($_FILES['photo']['tmp_name'])) {
	if($_FILES['photo']['error'] == 0 and substr($_FILES['photo']['type'], 0, 5) == "image") {
		$photoSmallName = randomName($_FILES['photo']['tmp_name']);
		$photoSmallDBName = $photoSmallName.".".substr($_FILES['photo']['name'], count($_FILES['photo']['name']) - 4, 4);
		$photoSmallUploadDir = '../../../img/photos/awards/small/';
		$photoSmallTmpName = $_FILES['photo']['tmp_name'];
		$photoSmallUpload = $photoSmallUploadDir.$photoSmallDBName;

		$photoBigName = randomName($_FILES['photo']['tmp_name']);
		$photoBigDBName = $photoBigName.".".substr($_FILES['photo']['name'], count($_FILES['photo']['name']) - 4, 4);
		$photoBigUploadDir = '../../../img/photos/awards/big/';
		$photoBigTmpName = $_FILES['photo']['tmp_name'];
		$photoBigUpload = $photoBigUploadDir.$photoBigDBName;

		$awardResult = $mysqli->query("SELECT * FROM awards WHERE id = '".$id."'");
		$award = $awardResult->fetch_assoc();

		if($mysqli->query("UPDATE awards SET name = '".$name."', photo_big = '".$photoBigDBName."', photo_small = '".$photoSmallDBName."' WHERE id = '".$id."'")) {
			$img = new SimpleImage($photoSmallTmpName);
			$img->resizeToWidth(95);
			$img->save($photoSmallUpload);
			move_uploaded_file($photoBigTmpName, $photoBigUpload);

			unlink("../../../img/photos/awards/big/".$award['photo_big']);
			unlink("../../../img/photos/awards/small/".$award['photo_small']);

			echo "ok";
		} else {
			echo "failed";
		}
	} else {
		echo "error";
	}
} else {
	if($mysqli->query("UPDATE awards SET name = '".$name."' WHERE id = '".$id."'")) {
		echo "ok";
	} else {
		echo "failed";
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;