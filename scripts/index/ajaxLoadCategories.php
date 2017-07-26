<?php

include("../connect.php");

$categoriesCountResult = $mysqli->query("SELECT COUNT(id) from categories_new WHERE type = '".$_POST['type']."'");
$categoriesCount = $categoriesCountResult->fetch_array(MYSQLI_NUM);

if($categoriesCount[0] > 10) {
	$categoriesResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$_POST['type']."' ORDER BY name LIMIT 10");
	while($categories = $categoriesResult->fetch_assoc()) {
		echo "<li><a href='catalogue/index.php?type=".$categories['type']."&c=".$categories['id']."&p=1'>".$categories['name']."</a></li>";
	}

	echo "<li><a href='catalogue/index.php?type=".$categories['type']."&&p=1'>+ Другие разделы</a></li>";
} else {
	$categoriesResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$_POST['type']."' ORDER BY name");

	while($categories = $categoriesResult->fetch_assoc()) {
		echo "<li><a href='catalogue/index.php?type=".$categories['type']."&c=".$categories['id']."&p=1'>".$categories['name']."</a></li>";
	}
}