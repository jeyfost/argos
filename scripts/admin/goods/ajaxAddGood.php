<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);
$goodSubcategory = $mysqli->real_escape_string($_POST['goodSubcategory']);
$goodSubcategory2 = $mysqli->real_escape_string($_POST['goodSubcategory2']);
$goodCurrency = $mysqli->real_escape_string($_POST['goodCurrency']);
$goodUnit = $mysqli->real_escape_string($_POST['goodUnit']);
$goodName = $mysqli->real_escape_string($_POST['goodName']);
$goodCode = $mysqli->real_escape_string($_POST['goodCode']);
$goodPrice = $mysqli->real_escape_string($_POST['goodPrice']);
$goodDescription = nl2br($mysqli->real_escape_string($_POST['goodDescription']));

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

if(!empty($_FILES['goodPhoto']['tmp_name']) and $_FILES['goodPhoto']['error'] == 0 and substr($_FILES['goodPhoto']['type'], 0, 5) == "image") {
	$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE code = '".$goodCode."'");
	$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

	if($goodCheck[0] == 0) {
		if($goodPrice > 0) {
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

			if(!empty($_FILES['goodBlueprint']['tmp_name'])) {
				if($_FILES['goodBlueprint']['error'] == 1 or substr($_FILES['goodBlueprint']['type'], 0, 5) != "image") {
					echo "blueprint";
				} else {
					$blueprintName = randomName($_FILES['goodBlueprint']['tmp_name']);
					$blueprintDBName = $blueprintName.".".substr($_FILES['goodBlueprint']['name'], count($_FILES['goodBlueprint']['name']) - 4, 4);
					$blueprintUploadDir = '../../../img/catalogue/sketch/';
					$blueprintTmpName = $_FILES['goodBlueprint']['tmp_name'];
					$blueprintUpload = $blueprintUploadDir.$blueprintDBName;

					if($mysqli->query("INSERT INTO catalogue_new (type, category, subcategory, subcategory2, name, picture, small, sketch, description, price, code, currency, unit) VALUES ('".$goodType."', '".$goodCategory."', '".$goodSubcategory."', '".$goodSubcategory2."', '".$goodName."', '".$bigPhotoDBName."', '".$smallPhotoDBName."', '".$blueprintDBName."', '".$goodDescription."', '".$goodPrice."', '".$goodCode."', '".$goodCurrency."', '".$goodUnit."')")) {
						image_resize($smallPhotoTmpName, $smallPhotoUpload, 100, 100);
						move_uploaded_file($bigPhotoTmpName, $bigPhotoUpload);
						move_uploaded_file($smallPhotoTmpName, $smallPhotoUpload);
						move_uploaded_file($blueprintTmpName, $blueprintUpload);

						echo "ok";
					} else {
						echo "error";
					}
				}
			} else {
				if($mysqli->query("INSERT INTO catalogue_new (type, category, subcategory, subcategory2, name, picture, small, sketch, description, price, code, currency, unit) VALUES ('".$goodType."', '".$goodCategory."', '".$goodSubcategory."', '".$goodSubcategory2."', '".$goodName."', '".$bigPhotoDBName."', '".$smallPhotoDBName."', '', '".$goodDescription."', '".$goodPrice."', '".$goodCode."', '".$goodCurrency."', '".$goodUnit."')")) {
					image_resize($smallPhotoTmpName, $smallPhotoUpload, 100, 100);
					move_uploaded_file($bigPhotoTmpName, $bigPhotoUpload);
					move_uploaded_file($smallPhotoTmpName, $smallPhotoUpload);

					echo "ok";
				} else {
					echo $mysqli->error;
				}
			}
		} else {
			echo "price";
		}
	} else {
		echo "code";
	}
} else {
	echo "photo";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;