<?php

include("../../connect.php");

$req = false;
ob_start();

$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);
$sectionName = $mysqli->real_escape_string($_POST['name']);

$sectionResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '".$goodCategory."'");
$section = $sectionResult->fetch_assoc();

$img = 0;
$imgSuccess = 0;

if($mysqli->query("UPDATE categories_new SET name = '".$sectionName."' WHERE id = '".$goodCategory."'")) {
	if(!empty($_FILES['blackImg']['tmp_name']) and $_FILES['blackImg']['error'] == 0 and substr($_FILES['blackImg']['type'], 0, 5) == "image") {
		$blackImgName = $_FILES['blackImg']['name'];
		$blackImgDBName = $blackImgName.".".substr($_FILES['blackImg']['name'], count($_FILES['blackImg']['name']) - 4, 4);
		$uploadDir = '../../../img/icons/';
		$blackImgTmpName = $_FILES['blackImg']['tmp_name'];
		$blackImgUpload = $uploadDir.$blackImgDBName;
		$img++;

		if($mysqli->query("UPDATE categories_new SET picture = '".$blackImgDBName."' WHERE id = '".$goodCategory."'")) {
			unlink("../../../img/icons/".$section['picture']);
			move_uploaded_file($blackImgTmpName, $blackImgUpload);
			$imgSuccess++;
		}
	}

	if(!empty($_FILES['redImg']['tmp_name']) and $_FILES['redImg']['error'] == 0 and substr($_FILES['redImg']['type'], 0, 5) == "image") {
		$redImgName = $_FILES['redImg']['name'];
		$redImgDBName = $redImgName.".".substr($_FILES['redImg']['name'], count($_FILES['redImg']['name']) - 4, 4);
		$uploadDir = '../../../img/icons/';
		$redImgTmpName = $_FILES['redImg']['tmp_name'];
		$redImgUpload = $uploadDir.$redImgDBName;
		$img++;

		if($mysqli->query("UPDATE categories_new SET picture_red = '".$redImgDBName."' WHERE id = '".$goodCategory."'")) {
			unlink("../../../img/icons/".$section['picture_red']);
			move_uploaded_file($redImgTmpName, $redImgUpload);
			$imgSuccess++;
		}
	}

	if($img > 0) {
		if($img > $imgSuccess) {
			echo "img";
		} else {
			echo "ok";
		}
	} else {
		echo "ok";
	}
} else {
	echo "error";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;