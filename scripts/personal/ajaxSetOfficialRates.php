<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 05.07.2017
 * Time: 11:56
 */

include("../connect.php");
include("../helpers.php");

$currenciesCountResult = $mysqli->query("SELECT COUNT(id) FROM currency WHERE code <> 'BYN'");
$currenciesCount = $currenciesCountResult->fetch_array(MYSQLI_NUM);

$success = 0;

$currencyResult = $mysqli->query("SELECT * FROM currency WHERE code <> 'BYN'");
while ($currency = $currencyResult->fetch_assoc()) {
	$data = "";

	while(empty($data)) {
		$data = file_get_contents_curl("http://www.nbrb.by/API/ExRates/Rates/" . $currency['code'] . "?ParamMode=2");
	}

	$nb = json_decode($data);
	$rate = $nb->Cur_OfficialRate / $nb->Cur_Scale;

	if ($mysqli->query("UPDATE currency SET rate = '" . $rate . "' WHERE code = '" . $currency['code'] . "'")) {
		$success++;
	}
}

if ($success == $currenciesCount[0]) {
	echo "ok";
} elseif ($success > 0 and $success < $currenciesCount[0]) {
	echo "partly";
} else {
	echo "failed";
}