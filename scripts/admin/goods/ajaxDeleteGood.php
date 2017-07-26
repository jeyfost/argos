<?php

include("../../connect.php");

$goodID = $mysqli->real_escape_string($_POST['goodID']);

$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$goodID."'");
$good = $goodResult->fetch_assoc();

if($mysqli->query("DELETE FROM catalogue_new WHERE id = '".$goodID."'")) {
	if(!empty($good['sketch'])) {
		unlink("../../../img/catalogue/sketch/".$good['sketch']);
	}

	unlink("../../../img/catalogue/big/".$good['picture']);
	unlink("../../../img/catalogue/small/".$good['small']);

	$photoResult = $mysqli->query("SELECT * FROM goods_photos WHERE good_id = '".$goodID."'");
	while($photo = $photoResult->fetch_assoc()) {
		unlink("../../../img/catalogue/photos/big/".$photo['big']);
		unlink("../../../img/catalogue/photos/small/".$photo['small']);
	}

	$mysqli->query("DELETE FROM goods_photos WHERE good_id = '".$goodID."'");

	echo "ok";
} else {
	echo "failed";
}