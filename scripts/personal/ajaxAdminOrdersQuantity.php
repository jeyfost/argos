<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 17.07.2017
 * Time: 7:26
 */

include("../connect.php");

$ordersQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = 0");
$ordersQuantity = $ordersQuantityResult->fetch_array(MYSQLI_NUM);

echo $ordersQuantity[0];