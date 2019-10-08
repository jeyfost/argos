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
$goodQuantity = $mysqli->real_escape_string($_POST['goodQuantity']);
$goodDescription = $mysqli->real_escape_string(str_replace("\n", "<br />", $_POST['goodDescription']));

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

/* функция для обработки дополнительных фотографий */

function resize($image, $w_o = false, $h_o = false)
{
	if (($w_o < 0) || ($h_o < 0)) {
		echo "Некорректные входные параметры";
		return false;
	}

	list($w_i, $h_i, $type) = getimagesize($image);

	$types = array("", "gif", "jpeg", "png");
	$ext = $types[$type]; // Зная "числовой" тип изображения, узнаём название типа

	if ($ext) {
		$func = 'imagecreatefrom' . $ext; // Получаем название функции, соответствующую типу, для создания изображения
		$img_i = $func($image); // Создаём дескриптор для работы с исходным изображением
	} else {
		echo 'Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый

		return false;
	}

	/* Если указать только 1 параметр, то второй подстроится пропорционально */
	if (!$h_o) $h_o = $w_o / ($w_i / $h_i);
	if (!$w_o) $w_o = $h_o / ($h_i / $w_i);

	$img_o = imagecreatetruecolor($w_o, $h_o); // Создаём дескриптор для выходного изображения

	imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); // Переносим изображение из исходного в выходное, масштабируя его

	$func = 'image' . $ext; // Получаем функция для сохранения результата

	return $func($img_o, $image); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции
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
	$a = 0;
	$aOK = 0;

	if($mysqli->query("UPDATE catalogue_new SET name = '".$goodName."', description = '".$goodDescription."', price = '".$goodPrice."', code = '".$goodCode."', currency = '".$goodCurrency."', unit = '".$goodUnit."', quantity = '".$goodQuantity."' WHERE id = '".$goodID."'")) {
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

		if(count($_FILES['goodAdditionalPhotos']['name']) > 0) {
			for($i = 0; $i < count($_FILES['goodAdditionalPhotos']['name']); $i++) {
				if(!empty($_FILES['goodAdditionalPhotos']['tmp_name'][$i]) and $_FILES['goodAdditionalPhotos']['error'][$i] == 0 and substr($_FILES['goodAdditionalPhotos']['type'][$i], 0, 5) == "image") {
                    $a++;

					$bigPhotoName = randomName($_FILES['goodAdditionalPhotos']['tmp_name'][$i]);
					$bigPhotoDBName = $bigPhotoName.".".substr($_FILES['goodAdditionalPhotos']['name'][$i], count($_FILES['goodAdditionalPhotos']['name'][$i]) - 4, 4);
					$bigPhotoUploadDir = "../../../img/catalogue/photos/big/";
					$bigPhotoTmpName = $_FILES['goodAdditionalPhotos']['tmp_name'][$i];
					$bigPhotoUpload = $bigPhotoUploadDir.$bigPhotoDBName;

					$smallPhotoName = randomName($_FILES['goodAdditionalPhotos']['tmp_name'][$i]);
					$smallPhotoDBName = $smallPhotoName.".".substr($_FILES['goodAdditionalPhotos']['name'][$i], count($_FILES['goodAdditionalPhotos']['name'][$i]) - 4, 4);
					$smallPhotoUploadDir = "../../../img/catalogue/photos/small/";
					$smallPhotoTmpName = $_FILES['goodAdditionalPhotos']['tmp_name'][$i];
					$smallPhotoUpload = $smallPhotoUploadDir.$smallPhotoDBName;

					if($mysqli->query("INSERT INTO goods_photos (good_id, small, big) VALUES ('".$goodID."', '".$smallPhotoDBName."', '".$bigPhotoDBName."')")) {
						copy($bigPhotoTmpName, $bigPhotoUpload);

						resize($smallPhotoTmpName, 100);
						move_uploaded_file($smallPhotoTmpName, $smallPhotoUpload);

						$aOK++;
					}
				}
			}
		}

		if($a == $aOK) {
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
			echo "additionalPhotos";
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