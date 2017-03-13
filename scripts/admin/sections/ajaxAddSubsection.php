<?php

include("../../connect.php");

$req = false;
ob_start();

$goodType = $mysqli->real_escape_string($_POST['goodType']);
$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);
$goodSubcategory = $mysqli->real_escape_string($_POST['goodSubcategory']);
$sectionName = $mysqli->real_escape_string($_POST['name']);

if(!empty($goodSubcategory)) {
	if($mysqli->query("INSERT INTO subcategories2 (subcategory, name) VALUES ('".$goodSubcategory."', '".$sectionName."')")) {
		echo "ok";
	} else {
		echo "error";
	}
} else {
	if($mysqli->query("INSERT INTO subcategories_new (type, category, name) VALUES ('".$goodType."', '".$goodCategory."', '".$sectionName."')")) {
		echo "ok";
	} else {
		echo "error";
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;