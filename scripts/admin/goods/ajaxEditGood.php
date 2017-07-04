<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);
$goodSubcategory = $mysqli->real_escape_string($_POST['goodSubcategory']);
$goodSubcategory2 = $mysqli->real_escape_string($_POST['goodSubcategory2']);
$goodID = $mysqli->real_escape_string($_POST['goodID']);
$goodCurrency = $mysqli->real_escape_string($_POST['goodCurrency']);
$goodUnit = $mysqli->real_escape_string($_POST['goodUnit']);
$goodName = $mysqli->real_escape_string($_POST['goodName']);
$goodCode = $mysqli->real_escape_string($_POST['goodCode']);
$goodPrice = $mysqli->real_escape_string($_POST['goodPrice']);
$goodDescription = $mysqli->real_escape_string( $_POST['goodDescription']);

function image_resize($source_path, $destination_path, $new_width, $quality = FALSE, $new_height = FALSE)
{
	ini_set("gd.jpeg_ignore_warning", 1);

	list($old_width, $old_height, $type) = getimagesize($source_path);

	switch($type)
	{
		case IMAGETYPE_JPEG:
			$typestr = 'jpeg';
			break;
		case IMAGETYPE_GIF:
			$typestr = 'gif';
			break;
		case IMAGETYPE_PNG:
			$typestr = 'png';
			break;
		default:
			break;
	}

	$function = "imagecreatefrom$typestr";
	$src_resource = $function($source_path);

	if(!$new_height)
	{
		$new_height = round($new_width * $old_height / $old_width);
	}
	elseif(!$new_width)
	{
		$new_width = round($new_height * $old_width / $old_height);
	}

	$destination_resource = imagecreatetruecolor($new_width, $new_height);

	imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

	if($type == 2)
	{
		imageinterlace($destination_resource, 1);
		imagejpeg($destination_resource, $destination_path, $quality);
	}
	else
	{
		$function = "image$typestr";
		$function($destination_resource, $destination_path);
	}

	imagedestroy($destination_resource);
	imagedestroy($src_resource);
}

function image_resize_h($source_path, $destination_path, $new_height, $quality = FALSE, $new_width = FALSE)
{
	ini_set("gd.jpeg_ignore_warning", 1);

	list($old_width, $old_height, $type) = getimagesize($source_path);

	switch($type)
	{
		case IMAGETYPE_JPEG:
			$typestr = 'jpeg';
			break;
		case IMAGETYPE_GIF:
			$typestr = 'gif';
			break;
		case IMAGETYPE_PNG:
			$typestr = 'png';
			break;
		default:
			break;
	}

	$function = "imagecreatefrom$typestr";
	$src_resource = $function($source_path);

	if(!$new_height)
	{
		$new_height = round($new_width * $old_height / $old_width);
	}
	elseif(!$new_width)
	{
		$new_width = round($new_height * $old_width / $old_height);
	}

	$destination_resource = imagecreatetruecolor($new_width, $new_height);

	imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

	if($type == 2)
	{
		imageinterlace($destination_resource, 1);
		imagejpeg($destination_resource, $destination_path, $quality);
	}
	else
	{
		$function = "image$typestr";
		$function($destination_resource, $destination_path);
	}

	imagedestroy($destination_resource);
	imagedestroy($src_resource);
}

function randomName($tmp_name)
{
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

$codeCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE code = '".$goodCode."' AND id <> '".$goodID."'");
$codeCheck = $codeCheckResult->fetch_array(MYSQLI_NUM);

if($codeCheck[0] == 0) {
	$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$goodID."'");
	$good = $goodResult->fetch_assoc();

	$bp = 0;
	$bpOK = 0;
	$p = 0;
	$pOK = 0;

	if($mysqli->query("UPDATE catalogue_new SET name = '".$goodName."', description = '".$goodDescription."', price = '".$goodPrice."', code = '".$goodCode."', currency = '".$goodCurrency."', unit = '".$goodUnit."' WHERE id = '".$goodID."'")) {
		if(!empty($_FILES['goodBlueprint']['tmp_name'])) {
			$bp = 1;

			if ($_FILES['goodBlueprint']['error'] == 0 and substr($_FILES['goodBlueprint']['type'], 0, 5) == "image") {
				$blueprintName = randomName($_FILES['goodBlueprint']['tmp_name']);
				$blueprintDBName = $blueprintName.".".substr($_FILES['goodBlueprint']['name'], count($_FILES['goodBlueprint']['name']) - 4, 4);
				$blueprintUploadDir = '../../../img/catalogue/sketch/';
				$blueprintTmpName = $_FILES['goodBlueprint']['tmp_name'];
				$blueprintUpload = $blueprintUploadDir.$blueprintDBName;

				if($mysqli->query("UPDATE catalogue_new SET sketch = '".$blueprintDBName."' WHERE id = '".$goodID."'")) {
					move_uploaded_file($blueprintTmpName, $blueprintUpload);

					if(!empty($good['sketch'])) {
						unlink($blueprintUploadDir.$good['sketch']);
					}

					$bpOK = 1;
				}
			}
		}

		if(!empty($_FILES['goodPhoto']['tmp_name'])) {
			$p = 1;

			if($_FILES['goodPhoto']['error'] == 0 and substr($_FILES['goodPhoto']['type'], 0, 5) == "image") {
				$bigPhotoName = randomName($_FILES['goodPhoto']['tmp_name']);
				$bigPhotoDBName = $bigPhotoName.".".substr($_FILES['goodPhoto']['name'], count($_FILES['goodPhoto']['name']) - 4, 4);
				$bigPhotoUploadDir = '../../../img/catalogue/big/';
				$bigPhotoTmpName = $_FILES['goodPhoto']['tmp_name'];
				$bigPhotoUpload = $bigPhotoUploadDir.$bigPhotoDBName;

				$smallPhotoName = randomName($_FILES['goodPhoto']['tmp_name']);
				$smallPhotoDBName = $smallPhotoName.".".substr($_FILES['goodPhoto']['name'], count($_FILES['goodPhoto']['name']) - 4, 4);
				$smallPhotoUploadDir = '../../../img/catalogue/small/';
				$smallPhotoTmpName = $_FILES['goodPhoto']['tmp_name'];
				$smallPhotoUpload = $smallPhotoUploadDir.$smallPhotoDBName;

				if($mysqli->query("UPDATE catalogue_new SET picture = '".$bigPhotoDBName."', small = '".$smallPhotoDBName."' WHERE id = '".$goodID."'")) {
					image_resize($smallPhotoTmpName, $smallPhotoUpload, 100, 100);
					move_uploaded_file($bigPhotoTmpName, $bigPhotoUpload);
					move_uploaded_file($smallPhotoTmpName, $smallPhotoUpload);

					unlink($bigPhotoUploadDir.$good['picture']);
					unlink($smallPhotoUploadDir.$good['small']);

					$pOK = 1;
				}
			}
		}

		if($p == 0 and $bp == 0) {
			echo "ok";
		}

		if($p == 1 and $bp == 1) {
			if($pOK == 0 and $bpOK == 0) {
				echo "photos";
			}

			if($pOK == 0 and $bpOK == 1) {
				echo "photo";
			}

			if ($pOK == 1 and $bpOK == 0) {
				echo "blueprint";
			}

			if($pOK == 1 and $bpOK == 1) {
				echo "ok";
			}
		}

		if($p == 0) {
			if($bp == 1 and $bpOK == 1) {
				echo "ok";
			}

			if($bp == 1 and $bpOK == 0) {
				echo "blueprint";
			}
		}

		if($bp == 0) {
			if($p == 1 and $pOK == 1) {
				echo "ok";
			}

			if($p == 1 and $pOK == 0) {
				echo "photo";
			}
		}
	} else {
		echo "failed";
	}
} else {
	echo "code";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;