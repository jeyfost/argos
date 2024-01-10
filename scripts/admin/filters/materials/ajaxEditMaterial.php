<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 10.01.2024
 * Time: 9:12
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$material = $mysqli->real_escape_string($_POST['material']);

if($mysqli->query("UPDATE handles_materials SET name = '".$material."' WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}