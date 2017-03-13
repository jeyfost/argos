<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$sectionName = $mysqli->real_escape_string($_POST['name']);

if(!empty($_FILES['blackImg']['tmp_name']) and $_FILES['blackImg']['error'] == 0 and substr($_FILES['blackImg']['type'], 0, 5) == "image") {
	if(!empty($_FILES['redImg']['tmp_name']) and $_FILES['redImg']['error'] == 0 and substr($_FILES['redImg']['type'], 0, 5) == "image") {
		$blackImgName = $_FILES['blackImg']['name'];
		$redImgName = $_FILES['redImg']['name'];
		$blackImgDBName = $blackImgName.".".substr($_FILES['blackImg']['name'], count($_FILES['blackImg']['name']) - 4, 4);
		$redImgDBName = $redImgName.".".substr($_FILES['redImg']['name'], count($_FILES['redImg']['name']) - 4, 4);
		$uploadDir = '../../../img/icons/';
		$blackImgTmpName = $_FILES['blackImg']['tmp_name'];
		$redImgTmpName = $_FILES['redImg']['tmp_name'];
		$blackImgUpload = $uploadDir.$blackImgDBName;
		$redImgUpload = $uploadDir.$redImgDBName;

		if($mysqli->query("INSERT INTO categories_new (type, name, picture, picture_red) VALUES ('".$goodType."', '".$sectionName."', '".$blackImgDBName."', '".$redImgDBName."')")) {
			move_uploaded_file($blackImgTmpName, $blackImgUpload);
			move_uploaded_file($redImgTmpName, $redImgUpload);

			echo "ok";
		} else {
			echo "error";
		}
	} else {
		echo "redImg";
	}
} else {
	echo "blackImg";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;