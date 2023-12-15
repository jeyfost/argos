<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.12.2023
 * Time: 9:16
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$color = $mysqli->real_escape_string($_POST['color']);

if($mysqli->query("UPDATE handles_colors SET name = '".$color."' WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}