<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 10.01.2024
 * Time: 16:28
 */

include ("../../../connect.php");

$handle = $mysqli->real_escape_string($_POST['handle']);
$material = $mysqli->real_escape_string($_POST['material']);
$type = $mysqli->real_escape_string($_POST['type']);
$color = $mysqli->real_escape_string($_POST['color']);
$brand = $mysqli->real_escape_string($_POST['brand']);
$size = $mysqli->real_escape_string($_POST['size']);

if($size > 0) {
    if($type == HANDLES_SK or $type == HANDLES_RE or $type == HANDLES_TO or $type == HANDLES_VS or $type == HANDLES_KS) {
        if($mysqli->query("UPDATE handles_specifications SET material_id = '".$material."', type_id = '".$type."', color_id = '".$color."', brand_id = '".$brand."', size_id = '".$size."' WHERE catalogue_id = '".$handle."'")) {
            echo "ok";
        } else {
            echo "failed";
        }
    } else {
        echo "size";
    }
} else {
    if($type == HANDLES_KN or $type == HANDLES_DK or $type == HANDLES_PO or $type == HANDLES_DD or $type == HANDLES_KK or $type == HANDLES_VR) {
        if($mysqli->query("UPDATE handles_specifications SET material_id = '".$material."', type_id = '".$type."', color_id = '".$color."', brand_id = '".$brand."', size_id = '' WHERE catalogue_id = '".$handle."'")) {
            echo "ok";
        } else {
            echo "failed";
        }
    }
}