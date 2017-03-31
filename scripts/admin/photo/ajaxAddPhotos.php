<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 29.03.2017
 * Time: 18:19
 */

include("../../connect.php");
include("../../simpleImage.php");

function randomName($tmp_name) {
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

$req = false;
ob_start();

$error = 0;

for($i = 0; $i < count($_FILES['photo']['name']); $i++) {
	if(empty($_FILES['photo']['tmp_name'][$i]) or $_FILES['photo']['error'][$i] != 0 or substr($_FILES['photo']['type'][$i], 0, 5) != "image") {
		$error++;
	}
}

if($error == 0) {
	$added = 0;

	for($i = 0; $i < count($_FILES['photo']['name']); $i++) {
		$photoSmallName = randomName($_FILES['photo']['tmp_name'][$i]);
		$photoSmallDBName = $photoSmallName.".".substr($_FILES['photo']['name'][$i], count($_FILES['photo']['name'][$i]) - 4, 4);
		$photoSmallUploadDir = '../../../img/photos/gallery/small/';
		$photoSmallTmpName = $_FILES['photo']['tmp_name'][$i];
		$photoSmallUpload = $photoSmallUploadDir.$photoSmallDBName;

		$photoBigName = randomName($_FILES['photo']['tmp_name'][$i]);
		$photoBigDBName = $photoBigName.".".substr($_FILES['photo']['name'][$i], count($_FILES['photo']['name'][$i]) - 4, 4);
		$photoBigUploadDir = '../../../img/photos/gallery/big/';
		$photoBigTmpName = $_FILES['photo']['tmp_name'][$i];
		$photoBigUpload = $photoBigUploadDir.$photoBigDBName;

		if($mysqli->query("INSERT INTO photos (album, photo_big, photo_small) VALUES ('".$_POST['album']."', '".$photoBigDBName."', '".$photoSmallDBName."')")) {
			$img = new SimpleImage($photoSmallTmpName);
			$img->resizeToWidth(95);
			$img->save($photoSmallUpload);
			move_uploaded_file($photoBigTmpName, $photoBigUpload);

			$added++;
		}
	}

	if($added == count($_FILES['photo']['name'])) {
		echo "ok";
	} else {
		if($added > 0) {
			echo "partly";
		} else {
			echo "failed";
		}
	}
} else {
	echo "error";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;