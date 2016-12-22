<?php

include("../connect.php");

$orderID = $mysqli->real_escape_string($_POST['orderID']);
$quantityResult = $mysqli->query("SELECT COUNT(id) FROM orders WHERE order_id = '".$orderID."'");
$quantity = $quantityResult->fetch_array(MYSQLI_NUM);

echo $quantity[0];