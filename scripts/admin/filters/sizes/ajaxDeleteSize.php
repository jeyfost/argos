<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.12.2023
 * Time: 8:51
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("DELETE FROM handles_sizes WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}