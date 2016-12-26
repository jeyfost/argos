<?php

session_start();
include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$userIDResult = $mysqli->query("SELECT user_id FROM orders_info WHERE id = '".$id."'");
$userID = $userIDResult->fetch_array(MYSQLI_NUM);
$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$userID[0]."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);
$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");
$total = 0;
echo "<div style='width: 100%; background-color: #ffeecb; height: 40px; line-height: 40px; font-size: 16px; text-align: center;'>Детализация заказа №".$id."</div><br /><br />";
if($discount[0] > 0) {
	echo "<p>В детализации показаны цены на товары с учётом личной скидки клиента. Размер скидки составляет <b>".$discount[0]."%</b></p><br /><br />";
}
while($order = $orderResult->fetch_assoc()) {
	$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$order['good_id']."'");
	$good = $goodResult->fetch_assoc();
	$currencyResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$good['currency']."'");
	$currency = $currencyResult->fetch_array(MYSQLI_NUM);
	$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
	$unit = $unitResult->fetch_assoc();
	$price = $good['price'] * $currency[0];
	$total += $price * $order['quantity'];
	$price = $price - $price * ($discount[0] / 100);
	$price = round($price, 2, PHP_ROUND_HALF_UP);
	$roubles = floor($price);
	$kopeck = ceil(($price - $roubles) * 100);
	echo "
		<div class='catalogueItem' id='ci".$good['id']."'>
			<div class='itemDescription'>
				<div class='catalogueIMG'>
					<a href='../img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='../img/catalogue/small/".$good['small']."' /></a>
				</div>
				<div class='catalogueInfo'>
					<div class='catalogueName'>
						<div style='width: 5px; height: 30px; background-color: #df4e47; position: relative; float: left;'></div>
						<div style='margin-left: 15px; font-size: 17px;'>".$good['name']."</div>
						<div style='clear: both;'></div>
					</div>
				<div class='catalogueDescription'>
	";
	$strings = explode("<br />", $good['description']);
	for($i = 0; $i < count($strings); $i++) {
		$string = explode(':', $strings[$i]);
		if(count($string) > 1) {
			echo "<b>".$string[0].":</b>".$string[1]."<br />";
		} else {
			echo $string[0]."<br />";
		}
	}
	echo "
		<br />
		<b>Артикул: </b>".$good['code']."
		<br />
		<div id='goodPrice".$good['id']."'>
			<span><b>Стоимость за ".$unit['short_name'].": </b>"; if($roubles > 0) {echo $roubles." руб. ";} echo $kopeck." коп.</span>
	";

	if($good['sketch'] != '') {
		echo "<br /><br /><a href='../img/catalogue/sketch/".$good['sketch']."' class='lightview'><span class='sketchFont'>Чертёж</span></a>";
	}

	echo "
					</div>
				</div>
			</div>
		</div>
		<div class='itemPurchase'>
			<img src='../img/system/delete.png' id='deleteIMG".$good['id']."' style='cursor: pointer; float: right;' title='Убрать товар из заказа' onmouseover='changeIcon(\"deleteIMG".$good['id']."\", \"deleteRed.png\", 1)' onmouseout='changeIcon(\"deleteIMG".$good['id']."\", \"delete.png\", 1)' onclick='removeGoodFromOrder(\"".$good['id']."\", \"".$id."\")' />
			<br /><br />
			<form method='post'>
				<label for='quantityInput".$good['id']."'>Кол-во в ".$unit['in_name'].":</label>
				<input type='number' id='quantityInput".$good['id']."' min='1' step='1' value='".$order['quantity']."' class='itemQuantityInput' onchange='changeQuantityDetailed(\"".$good['id']."\", \"".$id."\")' onkeyup='changeQuantityDetailed(\"".$good['id']."\", \"".$id."\")' />
			</form>
			<br />
			<div class='addingResult' id='addingResult".$good['id']."' onclick='hideBlock(\"addingResult".$good['id']."\")'></div>
			</div>
			<div style='clear: both;'></div>
		</div>
		<div style='width: 100%; height: 20px;' id='cis".$good['id']."'></div>
		<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;' id='cil".$good['id']."'></div>
		<div style='width: 100%; height: 20px;'></div>
	";
}

$total = $total - $total * ($discount[0] / 100);
$total = round($total, 2, PHP_ROUND_HALF_UP);
$roubles = floor($total);
$kopeck = ceil(($total - $roubles) * 100);

if($roubles == 0) {
	$total = $kopeck." коп.";
} else {
	$total = $roubles." руб. ".$kopeck." коп.";
}

echo "
	<br /><br />
	<div style='float: right;'><b>Личная скидка клиента: </b><span>".$discount[0]."%</span></div>
	<br />
	<div style='float: right;'><b>Общая стоимость: </b><span id='totalPriceText'>".$total."</span></div>
	<br /><br />
	<input type='button' id='acceptButton' onclick='acceptOrder(\"".$id."\")' value='Принять заказ' onmouseover='buttonChange(\"acceptButton\", 1)' onmouseout='buttonChange(\"acceptButton\", 0)'>
";