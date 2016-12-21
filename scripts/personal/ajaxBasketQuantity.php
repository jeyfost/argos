<?php

session_start();
include("../connect.php");

$quantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
$quantity = $quantityResult->fetch_array(MYSQLI_NUM);

echo $quantity[0];