<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 05.02.2020
 * Time: 14:21
 */

include("../../connect.php");

$fullName = $mysqli->real_escape_string($_POST['fullName']);
$name = $mysqli->real_escape_string($_POST['name']);
$position = $mysqli->real_escape_string($_POST['position']);
$phone = $mysqli->real_escape_string($_POST['phone']);

if($mysqli->query("INSERT INTO employees (full_name, name, position, phone) VALUES ('".$fullName."', '".$name."', '".$position."', '".$phone."')")) {
    echo "ok";
} else {
    echo "failed";
}