<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 10.07.2017
 * Time: 11:25
 */

include("../connect.php");
include("../helpers.php");

$currenciesCountResult = $mysqli->query("SELECT COUNT(id) FROM currency WHERE code <> 'BYN'");
$currenciesCount = $currenciesCountResult->fetch_array(MYSQLI_NUM);

$difference = 0;

$currencyResult = $mysqli->query("SELECT * FROM currency WHERE code <> 'BYN'");
while ($currency = $currencyResult->fetch_assoc()) {
	$data = "";

	while(empty($data)) {
		$data = file_get_contents_curl("https://www.nbrb.by/API/ExRates/Rates/" . $currency['code'] . "?ParamMode=2");
	}

	$nb = json_decode($data);
	$rate = $nb->Cur_OfficialRate / $nb->Cur_Scale;

	if ($rate != $currency['rate']) {
		$difference++;
	}
}

if ($difference > 0) {
	echo "not actual";
}