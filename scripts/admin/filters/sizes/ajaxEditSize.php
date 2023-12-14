<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 14.12.2023
 * Time: 16:55
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$size = $mysqli->real_escape_string($_POST['size']);

if($mysqli->query("UPDATE handles_sizes SET handle_size = '".$size."' WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}