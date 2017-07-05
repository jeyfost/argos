<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 05.07.2017
 * Time: 12:34
 */

include("../connect.php");

$code = $mysqli->real_escape_string($_REQUEST['code']);

$rateResult = $mysqli->query("SELECT rate FROM currency WHERE code = '".$code."'");
$rate = $rateResult->fetch_array(MYSQLI_NUM);

echo $rate[0];