<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$userResult = $mysqli->query("SELECT user_id FROM orders_info WHERE id = '".$id."'");
$user = $userResult->fetch_array(MYSQLI_NUM);

$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$user[0]."'");
$discount = $discountResult->fetch_array(MYSQLI_NUM);

$totalNormal = 0;
$totalAction = 0;

$orderResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");
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
	} else {
		$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$order['good_id']."' AND action_id = '".$aID."'");
		$actionGood = $actionGoodResult->fetch_assoc();

		$price = $actionGood['price'] * $currency[0];
		$totalAction += $price * $order['quantity'];
	}
}

$total = $totalAction + $totalNormal * (1 - $discount[0] / 100);
$roubles = floor($total);
$kopeck = round(($total - $roubles) * 100);

if($kopeck == 100) {
	$kopeck = 0;
	$roubles++;
}

if($kopeck < 10) {
	$kopeck = "0".$kopeck;
}

$total = $roubles.".".$kopeck;

if($mysqli->query("UPDATE orders_info SET summ = '".$total."', proceed_date = '".date('d-m-Y H:i:s')."', status = '1' WHERE id = '".$id."'")) {
	echo "a";
} else {
	echo "b";
}