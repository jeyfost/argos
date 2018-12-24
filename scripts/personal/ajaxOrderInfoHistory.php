<?php

session_start();
include("../connect.php");
include("../helpers.php");

$id = $mysqli->real_escape_string($_POST['id']);

$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);

$orderDateResult = $mysqli->query("SELECT send_date FROM orders_info WHERE id = '".$id."'");
$orderDate = $orderDateResult->fetch_array(MYSQLI_NUM);

$dateX = substr($orderDate[0], 0, 10);
$dateX = substr($dateX, 6, 4)."-".substr($dateX, 3, 2)."-".substr($dateX, 0, 2);
$aID = 0;
$actionGoodsQuantity = 0;

echo "<div style='width: 100%; background-color: #ffeecb; height: 40px; line-height: 40px; font-size: 16px; text-align: center;'>Детализация заказа №".$id."</div><br /><br />";

$actionResult = $mysqli->query("SELECT * FROM actions");
while($action = $actionResult->fetch_assoc()) {
	$date1 = $action['from_date'];
	$date2 = $action['to_date'];

	$date1 = substr($date1, 6, 4)."-".substr($date1, 3, 2)."-".substr($date1, 0, 2);
	$date2 = substr($date2, 6, 4)."-".substr($date2, 3, 2)."-".substr($date2, 0, 2);

	if($date1 <= $dateX and $dateX <= $date2) {
		$aID = $action['id'];
	}
}

$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");
while($order = $orderResult->fetch_assoc()) {
	$active = 0;

	$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$order['good_id']."'");
	$good = $goodResult->fetch_assoc();

	$currencyResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$good['currency']."'");
	$currency = $currencyResult->fetch_array(MYSQLI_NUM);

	if($aID == 0) {
		$price = $good['price'] * $currency[0];
		$price = $price * (1 - $discount[0] / 100);
	} else {
		$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$good['id']."' AND action_id = '".$aID."'");
		if($actionGoodResult->num_rows > 0) {
			$actionGood = $actionGoodResult->fetch_assoc();

			$active = 1;
			$actionGoodsQuantity++;
			$price = $actionGood['price'] * $currency[0];
		} else {
			$price = $good['price'] * $currency[0];
			$price = $price * (1 - $discount[0] / 100);
		}
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
			<table style='border: none; width: 100%;'>
				<tr>
					<td style='width: 100px;' valign='top'>
						<div class='catalogueIMG' onmouseover='actionIcon(\"actionIcon".$good['id']."\", 1)' onmouseout='actionIcon(\"actionIcon".$good['id']."\", 0)'>
							<a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
			";

			if($active > 0) {
				echo "<img src='/img/system/action_past.png' class='actionIMG' id='actionIcon".$good['id']."' />";
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
					<div id='goodPrice".$good['id']."'>
						<span><b>Стоимость за ".$unit['short_name'].": </b>"; if($active > 0) {echo "<span style='color: #ff282b; font-weight: bold;'>";} if($roubles > 0) {echo $roubles." руб. ";} echo $kopeck." коп.</span>"; if($active > 0) {echo "</span>";} echo "
				";

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
							<form method='post'>
								<label for='quantityInput".$good['id']."'>Кол-во в ".$unit['in_name'].":</label>
								<input type='number' value='".$order['quantity']."' class='itemQuantityInput' readonly/>
							</form>
							</div>
							<div style='clear: both;'></div>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div style='clear: both'></div>
		<div style='width: 100%; height: 20px;' id='cis".$good['id']."'></div>
		<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;' id='cil".$good['id']."'></div>
		<div style='width: 100%; height: 20px;'></div>
	";
}

$totalResult = $mysqli->query("SELECT summ FROM orders_info WHERE id = '".$id."'");
$total = $totalResult->fetch_array(MYSQLI_NUM);

$roubles = floor($total[0]);
$kopeck = round($total[0] - $roubles) * 100;

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
	echo "<span style='float: right; font-size: 14px; color: #ff282b;'>Ваша личная скидка не действует на акционные товары.</span><br /><br />";
}

echo "
	<div style='float: right;'><b>Общая стоимость на момент принятия заказа: </b><span id='totalPriceText'>".$total."</span></div>
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