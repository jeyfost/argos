<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 20.03.2017
 * Time: 13:13
 */

include("../../connect.php");
include("../../simpleImage.php");

$req = false;
ob_start();

$header = $mysqli->real_escape_string($_POST['header']);

function randomName($tmp_name)
{
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

if(!empty($_FILES['previewPhoto']['tmp_name']) and $_FILES['previewPhoto']['error'] == 0 and substr($_FILES['previewPhoto']['type'], 0, 5) == "image") {
	if($_POST['clientNews'] == "checked") {
		$client = 1;
	} else {
		$client = 0;
	}

	$previewName = randomName($_FILES['previewPhoto']['tmp_name']);
	$previewDBName = $previewName.".".substr($_FILES['previewPhoto']['name'], count($_FILES['previewPhoto']['name']) - 4, 4);
	$previewUploadDir = '../../../img/photos/news/';
	$previewTmpName = $_FILES['previewPhoto']['tmp_name'];
	$previewUpload = $previewUploadDir.$previewDBName;

	if($mysqli->query("INSERT INTO news (header, date, year, preview, text, client) VALUES ('".$header."', '".date('d-m-Y')."', '".date('Y')."', '".$previewDBName."', '".$_POST['newsText']."', '".$client."')")) {
		$img = new SimpleImage($previewTmpName);
		$img->resizeToWidth(200);
		$img->save($previewUpload);

		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "preview";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;