<?php

session_start();
include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);

$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");

$totalNormal = 0;
$totalAction = 0;
$actionGoodsQuantity = 0;

echo "<div style='width: 100%; background-color: #ffeecb; height: 40px; line-height: 40px; font-size: 16px; text-align: center;'>Детализация заказа №".$id."</div><br /><br />";

while($order = $orderResult->fetch_assoc()) {
	$active = 0;
	$aID = 0;

	$actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$order['good_id']."'");
	if($actionIDResult->num_rows > 0) {
		while($actionID = $actionIDResult->fetch_assoc()) {
			$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID['action_id']."'");
			$action = $actionResult->fetch_assoc();

			$dx = (int)date('d');
			$mx = (int)date('m');
			$yx = (int)date('Y');

			$d1 = (int)substr($action['from_date'], 0, 2);
			$m1 = (int)substr($action['from_date'], 3, 2);
			$y1 = (int)substr($action['from_date'], 6, 4);

			$d2 = (int)substr($action['to_date'], 0, 2);
			$m2 = (int)substr($action['to_date'], 3, 2);
			$y2 = (int)substr($action['to_date'], 6, 4);

			if($y1 < $yx and $yx < $y2) {
				$active++;
			}

			if($y1 < $yx and $yx == $y2) {
				if($mx < $m2) {
					$active++;
				}

				if($mx == $m2 and $dx <= $d2) {
					$active++;
				}
			}

			if($y1 == $yx) {
				if($m1 < $mx) {
					if($yx < $y2) {
						$active++;
					}

					if($yx == $y2) {
						if($mx < $m2) {
							$active++;
						}

						if($mx == $m2 and $dx <= $d2) {
							$active++;
						}
					}
				}

				if($m1 == $mx and $d1 <= $dx) {
					if($yx < $y2) {
						$active++;
					}

					if($yx == $y2) {
						if($mx < $m2) {
							$active++;
						}

						if($mx == $m2 and $dx <= $d2) {
							$active++;
						}
					}
				}
			}

			if($active > 0) {
				$aID = $actionID['action_id'];
				$actionGoodsQuantity++;
			}
		}
	}

	$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$order['good_id']."'");
	$good = $goodResult->fetch_assoc();

	$currencyResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$good['currency']."'");
	$currency = $currencyResult->fetch_array(MYSQLI_NUM);

	if($aID == 0) {
		$price = $good['price'] * $currency[0];
		$totalNormal += $price * $order['quantity'];
		$price = $price * (1 - $discount[0] / 100);
	} else {
		$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$order['good_id']."' AND action_id = '".$aID."'");
		$actionGood = $actionGoodResult->fetch_assoc();

		$price = $actionGood['price'] * $currency[0];
		$totalAction += $price * $order['quantity'];
	}

	$roubles = floor($price);
	$kopeck = round(($price - $roubles) * 100);
	if($kopeck == 100) {
		$kopeck = 0;
		$roubles ++;
	}

	$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
	$unit = $unitResult->fetch_assoc();

	echo "
		<div class='catalogueItem' id='ci".$good['id']."'>
			<div class='itemDescription'>
				<table style='border: none;'>
					<tr>
						<td style='width: 100px;' valign='top'>
							<div class='catalogueIMG' onmouseover='actionIcon(\"actionIcon".$good['id']."\", 1)' onmouseout='actionIcon(\"actionIcon".$good['id']."\", 0)'>
								<a href='../img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='../img/catalogue/small/".$good['small']."' /></a>
				";

				if($active > 0) {
					echo "<img src='../img/system/action.png' class='actionIMG' id='actionIcon".$good['id']."' />";
				}

				echo "
							</div>
						</td>
						<td>
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
						<span><b>Стоимость за ".$unit['short_name'].": </b>"; if($active > 0) {echo "<span style='color: #df4e47; font-weight: bold;'>";} if($roubles > 0) {echo $roubles." руб. ";} echo $kopeck." коп.</span>"; if($active > 0) {echo "</span'>";} echo "
				";

				if($good['sketch'] != '') {
					echo "<br /><br /><a href='../img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
				}

				echo "
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
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

$total = $totalAction + $totalNormal * (1 - $discount[0] / 100);
$roubles = floor($total);
$kopeck = round(($total - $roubles) * 100);

if($kopeck == 100) {
	$kopeck = 0;
	$roubles++;
}

if($roubles == 0) {
	$total = $kopeck." коп.";
} else {
	$total = $roubles." руб. ".$kopeck." коп.";
}

echo "
	<br /><br />
	<div style='float: right;'><b>Ваша личная скидка: </b><span>".$discount[0]."%</span></div>
	<br />
";

if($actionGoodsQuantity > 0) {
	echo "<span style='float: right; font-size: 14px; color: #df4e47;'>Ваша личная скидка не действует на акционные товары.</span><br /><br />";
}

echo "
	<div style='float: right;'><b>Общая стоимость: </b><span id='totalPriceText'>".$total."</span></div>
";