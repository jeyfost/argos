<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 19.02.2020
 * Time: 16:41
 */

include("../connect.php");

$user_id = $mysqli->real_escape_string($_POST['user_id']);
$order_id = $mysqli->real_escape_string($_POST['order_id']);
$good_id = $mysqli->real_escape_string($_POST['good_id']);
$quantity = $mysqli->real_escape_string($_POST['quantity']);

$mysqli->query("UPDATE orders SET quantity = '".$quantity."' WHERE good_id = '".$good_id."' AND order_id = '".$order_id."'");

$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$user_id."'");
$user = $userResult->fetch_assoc();

$totalPrice = 0;

$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$order_id."'");
while($order = $orderResult->fetch_assoc()) {
    $goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$order['good_id']."'");
    $good = $goodResult->fetch_assoc();

    $active = 0;

    $actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$good['id']."'");
    if($actionIDResult->num_rows > 0) {
        while($actionID = $actionIDResult->fetch_assoc()) {
            $actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID['action_id']."'");
            $action = $actionResult->fetch_assoc();
            $from = strtotime($action['from_date']);
            $to = strtotime($action['to_date']);
            $today = strtotime(date('d-m-Y'));

            if($today >= $from and $today <= $to) {
                $active = 1;
                $aID = $action['id'];
            }
        }
    }

    $currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
    $currency = $currencyResult->fetch_assoc();

    if($active == 0) {
        if($user['opt'] == 1) {
            $price = $good['price_opt'];
        } else {
            $price = $good['price'];
        }

        $totalPrice += ($price - $price * $user['discount'] / 100) * $currency['rate'] * $order['quantity'];
    } else {
        $actionPriceResult = $mysqli->query("SELECT price FROM action_goods WHERE action_id = '".$aID."'");
        $actionPrice = $actionPriceResult->fetch_array(MYSQLI_NUM);

        $totalPrice += $actionPrice[0] * $currency['rate'] * $order['quantity'];
    }
}

$roubles = floor($totalPrice);
$kopeck = ceil(($totalPrice - $roubles) * 100);

if($kopeck == 100) {
    $kopeck = 0;
    $roubles ++;
}

if($roubles == 0 and $kopeck == 0) {
    $kopeck = 1;
}

$kopeck = ceil($kopeck);

if(strlen($kopeck) == 1) {
    $kopeck = "0".$kopeck;
}

$totalPrice = $roubles." руб. ".$kopeck." коп.";

echo $totalPrice;