<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$sectionName = $mysqli->real_escape_string($_POST['name']);

$categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM categories_new WHERE name = '".$sectionName."'");
$categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

if($categoryCheck[0] == 0) {
	echo "ok";
} else {
	echo "false";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;