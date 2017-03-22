<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 22.03.2017
 * Time: 10:26
 */

include("../../connect.php");
include("../../simpleImage.php");

function randomName($tmp_name)
{
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

$req = false;
ob_start();

$header = $mysqli->real_escape_string($_POST['header']);

if($_POST['clientNews'] == "checked") {
	$client = 1;
} else {
	$client = 2;
}

$newsResult = $mysqli->query("SELECT * FROM news WHERE id = '".$_POST['news']."'");
$news = $newsResult->fetch_assoc();

if(!empty($_FILES['previewPhoto']['name'])) {
	if($_FILES['previewPhoto']['error'] == 0 and substr($_FILES['previewPhoto']['type'], 0, 5) == "image") {
		$previewName = randomName($_FILES['previewPhoto']['tmp_name']);
		$previewDBName = $previewName.".".substr($_FILES['previewPhoto']['name'], count($_FILES['previewPhoto']['name']) - 4, 4);
		$previewUploadDir = '../../../img/photos/news/';
		$previewTmpName = $_FILES['previewPhoto']['tmp_name'];
		$previewUpload = $previewUploadDir.$previewDBName;

		if($mysqli->query("UPDATE news SET header = '".$header."', preview = '".$previewDBName."', text = '".$_POST['newsText']."', client = '".$client."' WHERE id = '".$news['id']."'")) {
			$img = new SimpleImage($previewTmpName);
			$img->resizeToWidth(200);
			$img->save($previewUpload);

			unlink("../../../img/photos/news/".$news['preview']);

			echo "ok";
		} else {
			echo "failed";
		}
	} else {
		echo "preview";
	}
} else {
	if($mysqli->query("UPDATE news SET header = '".$header."', text = '".$_POST['newsText']."', client = '".$client."' WHERE id = '".$_POST['news']."'")) {
		echo "ok";
	} else {
		echo "failed";
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;