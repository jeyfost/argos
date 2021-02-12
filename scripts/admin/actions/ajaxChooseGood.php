<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 22.03.2017
 * Time: 18:12
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$randomID = substr($mysqli->real_escape_string($_POST['block']), 2);

$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$id."'");
$good = $goodResult->fetch_assoc();
$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
$unit = $unitResult->fetch_assoc();
$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
$currency = $currencyResult->fetch_assoc();

$price = $good['price'] * $currency['rate'];
$price_opt = $good['price_opt'] * $currency['rate'];

$roubles = floor($price);
$kopeck = ceil(($price - $roubles) * 100);

if($kopeck == 100) {
    $kopeck = 0;
    $roubles ++;
}

if($roubles == 0 and $kopeck == 0) {
    $kopeck = 1;
}

$kopeck = ceil($kopeck);

if(strlen($kopeck) == 1) {
    $kopeck = "0".$kopeck;
}

$price = $roubles." руб. ".$kopeck." коп.";

$roubles = floor($price_opt);
$kopeck = ceil(($price_opt - $roubles) * 100);

if($kopeck == 100) {
    $kopeck = 0;
    $roubles ++;
}

if($roubles == 0 and $kopeck == 0) {
    $kopeck = 1;
}

$kopeck = ceil($kopeck);

if(strlen($kopeck) == 1) {
    $kopeck = "0".$kopeck;
}

$price_opt = $roubles." руб. ".$kopeck." коп.";

$today = strtotime(date('d-m-Y'));
$actionCount = 0;
$status = "<br /><br />Товар принимает участие в следущих акциях: ";

$goodActionResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$good['id']."'");
while($goodAction = $goodActionResult->fetch_assoc()) {
	$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$goodAction['action_id']."'");

	while($action = $actionResult->fetch_assoc())
	{
		if(strtotime($action['from_date']) >= $today or (strtotime($action['from_date']) < $today and strtotime($action['to_date']) >= $today)) {
			$actionCount++;
			$status .= "c <span style='color: #ff282b;'>".$action['from_date']."</span> по <span style='color: #ff282b;'>".$action['to_date']."</span>; ";
		}
	}
}

if($actionCount > 0) {
	$status = substr($status, 0 , strlen($status) - 2).".";
} else {
	$status = "";
}

echo "
	<br />
	<div class='goodImg'>
		<a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
	</div>
	<div class='goodInfo'>
		<div class='goodName'>
			<div style='width: 5px; height: 30px; background-color: #ff282b; position: relative; float: left;'></div>
			<div style='margin-left: 15px;'><a href='/catalogue/item.php?id=".$good['id']."' target='_blank'><span class='catalogueNameLink'>".$good['name']."</span></a></div>
			<div style='clear: both;'></div>
		</div>
		<div class='goodDescription'>
";
$description = str_replace("\n", "<br />", $good['description']);
$strings = explode("<br />", $description);
for($i = 0; $i < count($strings); $i++) {
	$string = explode(':', $strings[$i]);
	if(count($string) > 1) {
		for($j = 0; $j < count($string); $j++) {
			if($j == 0) {
				echo "<b>".$string[$j].":</b>";
			} else {
				if($j == (count($string) - 1)) {
					echo $string[$j];
				} else {
					echo $string[$j].":";
				}
			}
		}
		echo "<br />";
	} else {
		echo $string[0]."<br />";
	}
}
echo "
			<br />
			<b>Артикул: </b>".$good['code']."
			<br />
			<span><b>Цена розничная за ".$unit['for_name'].": </b>".$price."</span>
			<br />
			<span><b>Цена оптовая за ".$unit['for_name'].": </b>".$price_opt."</span>
			".$status."
			<br /><br >
			<label for='np_".$randomID."'>Акционная стоимость в <b>".$currency['code']." (".$currency['currency_name'].")</b>:</label>
			<br />
			<input type='number' min='0.0001' step='0.0001' class='actionGoodPrice' id='np_".$randomID."' name='price' />
";

if($good['sketch'] != '') {
	echo "<br /><br /><a href='/img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
}

echo "
		</div>
		<div style='clear: both;'></div>
";