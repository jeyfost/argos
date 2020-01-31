<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 31.01.2020
 * Time: 15:03
 */

    include("../connect.php");

    $hash = $mysqli->real_escape_string($_POST['hash']);

    $clientCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE hash = '".$hash."' AND in_send = '1'");
    $clientCheck = $clientCheckResult->fetch_array(MYSQLI_NUM);

    if($clientCheck[0] > 0) {
        if($mysqli->query("UPDATE clients SET in_send = '0', disactivation_date = '".date('Y-m-d')."' WHERE hash = '".$hash."'")) {
            echo "ok";
        } else {
            echo "failed";
        }
    } else {
        echo "hash";
    }