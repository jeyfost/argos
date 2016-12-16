<?php

session_start();
include("../connect.php");

$sort = $mysqli->real_escape_string($_POST['sort']);

if($_SESSION['sort'] == $sort) {
	if($_SESSION['sort_type'] == "ASC") {
		$_SESSION['sort_type'] = "DESC";
	} else {
		$_SESSION['sort_type'] = "ASC";
	}
} else {
	$_SESSION['sort'] = $sort;
	$_SESSION['sort_type'] = "ASC";
}