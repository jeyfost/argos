<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.07.2017
 * Time: 10:05
 */

include("../../connect.php");

$req = false;
ob_start();

$goodID = $mysqli->real_escape_string($_POST['goodID']);

$photoResult = $mysqli->query("SELECT * FROM goods_photos WHERE good_id = '".$goodID."'");
while($photo = $photoResult->fetch_assoc()) {
	echo "
		<div class='goodPhotoContainer' onmouseover='fadePhoto(\"goodPhoto".$photo['id']."\", 1)' onmouseout='fadePhoto(\"goodPhoto".$photo['id']."\", 0)'>
			<a href='../../img/catalogue/photos/big/".$photo['big']."' class='lightview' data-lightview-group='good'><img src='../../img/catalogue/photos/small/".$photo['small']."' class='goodPhoto' id='goodPhoto".$photo['id']."' /></a>
			<i class='fa fa-trash font-awesome-link' aria-hidden='true' onclick='deletePhoto(\"".$photo['id']."\", \"".$good['id']."\")'></i>
		</div>
	";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;