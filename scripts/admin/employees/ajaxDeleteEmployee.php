<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 05.02.2020
 * Time: 15:33
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

if($mysqli->query("DELETE FROM employees WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}