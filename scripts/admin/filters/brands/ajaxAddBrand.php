<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 13.12.2023
 * Time: 15:19
 */

include("../../../connect.php");

$name = $mysqli->real_escape_string($_POST['name']);

$nameCheckResult = $mysqli->query("SELECT COUNT(id) FROM handles_brands WHERE name = '".$name."'");
$nameCheck = $nameCheckResult->fetch_array(MYSQLI_NUM);

if($nameCheck[0] == 0) {
    if($mysqli->query("INSERT INTO handles_brands (name) VALUES ('".$name."')")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "duplicate";
}