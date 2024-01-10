<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 10.01.2024
 * Time: 9:25
 */

include("../../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("DELETE FROM handles_materials WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}
