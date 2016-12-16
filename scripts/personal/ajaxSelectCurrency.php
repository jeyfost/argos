<?php

include("../connect.php");

$id = "";
$currencyResult = $mysqli->query("SELECT * FROM currency");
while($currency = $currencyResult->fetch_assoc()) {
	$id .= $currency['id'].",";
}

$id = substr($id, 0, strlen($id) - 1);

echo $id;