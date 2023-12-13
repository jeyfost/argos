<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 13.12.2023
 * Time: 16:30
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$name = $mysqli->real_escape_string($_POST['name']);

if($mysqli->query("UPDATE handles_brands SET name = '".$name."' WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}