<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.12.2023
 * Time: 9:04
 */

include("../../../connect.php");

$color = $mysqli->real_escape_string($_POST['color']);

$colorCheckResult = $mysqli->query("SELECT COUNT(id) FROM handles_colors WHERE name = '".$color."'");
$colorCheck = $colorCheckResult->fetch_array(MYSQLI_NUM);

if($colorCheck[0] == 0) {
    if($mysqli->query("INSERT INTO handles_colors (name) VALUES ('".$color."')")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "duplicate";
}