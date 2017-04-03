<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 7:57
 */

include("../../connect.php");

$req = false;
ob_start();

$position = $mysqli->real_escape_string($_POST['position']);
$id = $mysqli->real_escape_string($_POST['vacancy']);

$vacancyCheckResult = $mysqli->query("SELECT COUNT(id) FROM vacancies WHERE position = '".$position."' AND opened = '1' AND id <> '".$id."'");
$vacancyCheck = $vacancyCheckResult->fetch_array(MYSQLI_NUM);

if($vacancyCheck[0] == 0) {
	if($mysqli->query("UPDATE vacancies SET position = '".$position."', text = '".$_POST['text']."' WHERE id = '".$id."'")) {
		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "duplicate";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;