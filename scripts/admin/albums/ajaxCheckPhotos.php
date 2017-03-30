<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.03.2017
 * Time: 14:50
 */

include("../../connect.php");

$req = false;
ob_start();

$photoCheckResult = $mysqli->query("SELECT COUNT(id) FROM photos WHERE album = '".$_POST['album']."'");
$photoCheck = $photoCheckResult->fetch_array(MYSQLI_NUM);

if($photoCheck[0] == 0) {
	echo "no";
} else {
	echo "yes";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;