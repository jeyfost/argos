<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.12.2023
 * Time: 10:44
 */

include("../../../connect.php");

$material = $mysqli->real_escape_string($_POST['material']);

$materialCheckResult = $mysqli->query("SELECT COUNT(id) FROM handles_materials WHERE name = '".$material."'");
$materialCheck = $materialCheckResult->fetch_array(MYSQLI_NUM);

if($materialCheck[0] == 0) {
    if($mysqli->query("INSERT INTO handles_materials (name) VALUES ('".$material."')")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "duplicate";
}