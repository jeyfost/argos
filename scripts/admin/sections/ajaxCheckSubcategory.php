<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);
$goodSubcategory = $mysqli->real_escape_string($_POST['goodSubcategory']);
$goodSubcategory2 = $mysqli->real_escape_string($_POST['goodSubcategory2']);
$sectionName = $mysqli->real_escape_string($_POST['name']);

if(!empty($goodSubcategory)) {
	$categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE name = '".$sectionName."' AND subcategory = '".$goodSubcategory."'");
	$categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);
} else {
	$categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE name = '".$sectionName."' AND category = '".$goodCategory."'");
	$categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);
}

if($categoryCheck[0] == 0) {
	echo "ok";
} else {
	echo "false";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;