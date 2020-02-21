<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 20.02.2020
 * Time: 10:26
 */

include("../connect.php");

$order_id = $mysqli->real_escape_string($_POST['order_id']);
$good_id = $mysqli->real_escape_string($_POST['good_id']);

if(!empty($good_id)) {
    if($mysqli->query("DELETE FROM orders WHERE order_id = '".$order_id."' AND good_id = '".$good_id."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "ok";
}
