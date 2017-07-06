<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.07.2017
 * Time: 15:09
 */

session_start();
include("../connect.php");

$id = $mysqli->real_escape_string($_POST['order_id']);
$text = $mysqli->real_escape_string(nl2br($_POST['text']));

$orderCheckResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE id = '".$id."'");
$orderCheck = $orderCheckResult->fetch_array(MYSQLI_NUM);

if($orderCheck[0] > 0) {
	if($mysqli->query("INSERT INTO orders_comments (order_id, user_id, date, text) VALUES ('".$id."', '".$_SESSION['userID']."', '".date("Y-m-d H:i:s")."', '".$text."')")) {
		echo "ok";
	} else {
		echo "failed";
	}
} else {
	echo "id";
}