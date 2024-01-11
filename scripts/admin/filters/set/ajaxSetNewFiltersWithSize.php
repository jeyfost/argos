<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 11.01.2024
 * Time: 10:52
 */

include ("../../../connect.php");

$handle = $mysqli->real_escape_string($_POST['handle']);
$material = $mysqli->real_escape_string($_POST['material']);
$type = $mysqli->real_escape_string($_POST['type']);
$color = $mysqli->real_escape_string($_POST['color']);
$brand = $mysqli->real_escape_string($_POST['brand']);
$size = $mysqli->real_escape_string($_POST['size']);

if($mysqli->query("INSERT INTO handles_specifications (catalogue_id, type_id, material_id, size_id, color_id, brand_id) VALUES ('".$handle."', '".$type."', '".$material."', '".$size."', '".$color."', '".$brand."')")) {
    echo "ok";
} else {
    echo "failed";
}