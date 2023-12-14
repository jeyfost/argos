<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 14.12.2023
 * Time: 16:41
 */

include("../../../connect.php");

$size = $mysqli->real_escape_string($_POST['size']);

$sizeCheckResult = $mysqli->query("SELECT COUNT(id) FROM handles_sizes WHERE handle_size = '".$size."'");
$sizeCheck = $sizeCheckResult->fetch_array(MYSQLI_NUM);

if($sizeCheck[0] == 0) {
    if($mysqli->query("INSERT INTO handles_sizes (handle_size) VALUES ('".$size."')")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "duplicate";
}