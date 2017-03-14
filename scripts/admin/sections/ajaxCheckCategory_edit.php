<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$sectionName = $mysqli->real_escape_string($_POST['name']);
$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);

$categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM categories_new WHERE name = '".$sectionName."' AND id <> '".$goodCategory."'");
$categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

$currentNameResult = $mysqli->query("SELECT name FROM categories_new WHERE id = '".$goodCategory."'");
$currentName = $currentNameResult->fetch_array(MYSQLI_NUM);

if($currentName[0] != $sectionName) {
	if($categoryCheck[0] == 0) {
		echo "ok";
	} else {
		echo "false";
	}
} else {
	echo "no";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;