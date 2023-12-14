<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 14.12.2023
 * Time: 15:35
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("DELETE FROM handles_brands WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}