<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 29.03.2017
 * Time: 15:27
 */

include("../../connect.php");

$req = false;
ob_start();

$goodCountResult = $mysqli->query("SELECT COUNT(id) FROM action_goods WHERE action_id = '".$_POST['action']."'");
$goodCount = $goodCountResult->fetch_array(MYSQLI_NUM);

$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$_POST['action']."'");
$action = $actionResult->fetch_assoc();

if($goodCount[0] > 0) {
	//если акция с товарами

	$count = 0;

	if($mysqli->query("DELETE FROM action_goods WHERE action_id = '".$_POST['action']."'")) {
		$count++;
	}
}

if($mysqli->query("DELETE FROM actions WHERE id = '".$_POST['action']."'")) {
	unlink("../../../img/photos/actions/".$action['preview']);

	if(($goodCount[0] > 0 and $count == $goodCount[0]) or $goodCount[0] == 0) {
		echo "ok";
	}

	if($goodCount[0] > 0 and $count < $goodCount[0]) {
		echo "goods";
	}
} else {
	if($goodCount[0] > 0) {
		if($count == $goodCount[0]) {
			echo "failedGoodsOk";
		} else {
			echo "failed";
		}
	} else {
		echo "failed";
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;