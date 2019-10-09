<?php

session_start();
include("../connect.php");
include("../helpers.php");

$id = $mysqli->real_escape_string($_POST['id']);

$userIDResult = $mysqli->query("SELECT user_id FROM orders_info WHERE id = '".$id."'");
$userID = $userIDResult->fetch_array(MYSQLI_NUM);

$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$userID[0]."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);

$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");

$totalNormal = 0;
$totalAction = 0;
$actionGoodsQuantity = 0;

echo "<div style='width: 100%; background-color: #ffeecb; height: 40px; line-height: 40px; font-size: 16px; text-align: center;'>Детализация заказа №".$id."</div><br /><br />";

if($discount[0] > 0) {
	echo "<p>В детализации показаны цены на товары с учётом личной скидки клиента. Размер скидки составляет <b>".$discount[0]."%.</b><span style='color: #ff282b;'> На акционные товары скидка не распространяется.</span></p><br /><br />";
}

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
	$kopeck = ceil(($price - $roubles) * 100);

	if($kopeck == 100) {
		$kopeck = 0;
		$roubles ++;
	}

	$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
	$unit = $unitResult->fetch_assoc();

	echo "
		<div class='catalogueItem' id='ci".$good['id']."'>
			<div class='itemDescription'>
				<table style='border: none; width: 100%;'>
					<tr>
						<td style='width: 100px;' valign='top'>
							<div class='catalogueIMG' onmouseover='actionIcon(\"actionIcon".$good['id']."\", 1)' onmouseout='actionIcon(\"actionIcon".$good['id']."\", 0)'>
								<a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
				";

				if($active > 0) {
					echo "<img src='/img/system/action.png' class='actionIMG' id='actionIcon".$good['id']."' />";
				}

				echo "
							</div>
						</td>
						<td>
							<div class='catalogueInfo'>
								<div class='catalogueName'>
									<div style='width: 5px; height: 30px; background-color: #ff282b; position: relative; float: left;'></div>
									<div style='margin-left: 15px; font-size: 17px;'><a href='/catalogue/item.php?id=".$good['id']."' class='catalogueNameLink'>".$good['name']."</a></div>
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
                    <b>Наличие: </b>"; if($good['quantity'] > 0) {echo "на складе";} else {echo "нет на складе";} echo "
					<br />
					<div id='goodPrice".$good['id']."'>
						<span><b>Стоимость за ".$unit['short_name'].": </b>"; if($active > 0) {echo "<span style='color: #ff282b; font-weight: bold;'>";} echo $roubles." руб. "; $kopeck = ceil($kopeck); if(strlen($kopeck) == 1) {$kopeck = "0".$kopeck;} echo $kopeck." коп.</span>"; if($active > 0) {echo "</span>";}

				if($good['sketch'] != '') {
					echo "<br /><br /><a href='/img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
				}

				echo "
								</div>
							</div>
						</div>
					</td>
					<td style='width: 65px; vertical-align: top;'>
						<div class='itemPurchase'>
							<img src='/img/system/delete.png' id='deleteIMG".$good['id']."' style='cursor: pointer; float: right;' title='Убрать товар из заказа' onmouseover='changeIcon(\"deleteIMG".$good['id']."\", \"deleteRed.png\", 1)' onmouseout='changeIcon(\"deleteIMG".$good['id']."\", \"delete.png\", 1)' onclick='removeGoodFromOrder(\"".$good['id']."\", \"".$id."\")' />
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
					</td>
				</tr>
			</table>
		</div>
		<div style='clear: both;'></div>
		<div style='width: 100%; height: 20px;' id='cis".$good['id']."'></div>
		<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;' id='cil".$good['id']."'></div>
		<div style='width: 100%; height: 20px;'></div>
	";
}

$total = $totalAction + $totalNormal * (1 - $discount[0] / 100);
$roubles = floor($total);
$kopeck = ceil(($total - $roubles) * 100);

if($kopeck == 100) {
	$kopeck = 0;
	$roubles++;
}

$kopeck = ceil($kopeck);

if(strlen($kopeck) == 1) {
    $kopeck = "0".$kopeck;
}

$total = $roubles." руб. ".$kopeck." коп.";

echo "
	<br /><br />
	<div style='float: right;'><b>Личная скидка клиента: </b><span>".$discount[0]."%</span></div>
	<br />
";

if($actionGoodsQuantity > 0) {
	echo "<span style='float: right; font-size: 14px; color: #ff282b;'>Личная скидка клиента не действует на акционные товары.</span><br /><br />";
}

echo "
	<div style='float: right;'><b>Общая стоимость: </b><span id='totalPriceText'>".$total."</span></div>
	<br /><br />
	<input type='button' id='acceptButton' onclick='acceptOrder(\"".$id."\")' value='Принять заказ' onmouseover='buttonChange(\"acceptButton\", 1)' onmouseout='buttonChange(\"acceptButton\", 0)'>
";

$commentsCountResult = $mysqli->query("SELECT COUNT(id) FROM orders_comments WHERE order_id = '".$id."'");
$commentsCount = $commentsCountResult->fetch_array(MYSQLI_NUM);

if($commentsCount[0] == 0) {
	echo "
		<div id='addComment'><span class='tdLink' onclick='showCommentField(\"".$id."\")'>Добавить комментарий к заказу</span></div>
		<div id='orderCommentsField'></div>
	";
} else {
	$commentsResult = $mysqli->query("SELECT * FROM orders_comments WHERE order_id = '".$id."' ORDER BY date");

	echo "
		<div id='orderCommentsField'>
			<h3>Комментарии к заказу</h3>
			<hr /><br />
	";

	$number = 0;

	while($comment = $commentsResult->fetch_assoc()) {
		$number++;

		$authorResult = $mysqli->query("SELECT name FROM users WHERE id = '".$comment['user_id']."'");
		$author = $authorResult->fetch_array(MYSQLI_NUM);

		echo "
			<div class='orderComment'>
				<div style='border-bottom: 1px dotted #999; padding: 5px;'><b>Комментарий №".$number."</b> от <b>".dateFormatted($comment['date'])."</b>. Автор: <b>"; if($comment['user_id'] == 1) {echo "<span style='color: #ff282b;'>".$author[0]."</span>";} else {echo $author[0];} echo "</b></div>
				<div class='commentSection'><br />".$comment['text']."</div>
			</div>
		";
	}

	echo "
		<br />
		<div id='addComment'><span class='tdLink' onclick='showCommentField(\"".$id."\")'>Добавить комментарий к заказу</span></div>
	";

	echo "</div>";
}