<?php

include("../../connect.php");

$req = false;
ob_start();

$goodSubcategory = $mysqli->real_escape_string($_POST['goodSubcategory']);
$goodSubcategory2 = $mysqli->real_escape_string($_POST['goodSubcategory2']);
$sectionName = $mysqli->real_escape_string($_POST['name']);

$sectionResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '".$goodCategory."'");
$section = $sectionResult->fetch_assoc();

if(!empty($goodSubcategory2)) {
	if($mysqli->query("UPDATE subcategories2 SET name = '".$sectionName."' WHERE id = '".$goodSubcategory2."'")) {
		echo "ok";
	} else {
		echo "error";
	}
} else {
	if($mysqli->query("UPDATE subcategories_new SET name = '".$sectionName."' WHERE id = '".$goodSubcategory."'")) {
		echo "ok";
	} else {
		echo "error";
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;