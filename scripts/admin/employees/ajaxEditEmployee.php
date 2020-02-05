<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 05.02.2020
 * Time: 15:05
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$fullName = $mysqli->real_escape_string($_POST['fullName']);
$name = $mysqli->real_escape_string($_POST['name']);
$position = $mysqli->real_escape_string($_POST['position']);
$phone = $mysqli->real_escape_string($_POST['phone']);

if($mysqli->query("UPDATE employees SET full_name = '".$fullName."', name = '".$name."', position = '".$position."', phone = '".$phone."'")) {
    echo "ok";
} else {
    echo "failed";
}