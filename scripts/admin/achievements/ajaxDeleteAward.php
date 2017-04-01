<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 01.04.2017
 * Time: 15:13
 */

include("../../connect.php");

$req = false;
ob_start();

$id = $mysqli->real_escape_string($_POST['award']);

$awardResult = $mysqli->query("SELECT * FROM awards WHERE id = '".$id."'");
$award = $awardResult->fetch_assoc();

if($mysqli->query("DELETE FROM awards WHERE id = '".$id."'")) {
	unlink("../../../img/photos/awards/big/".$award['photo_big']);
	unlink("../../../img/photos/awards/small/".$award['photo_small']);

	echo "ok";
} else {
	echo "failed";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;