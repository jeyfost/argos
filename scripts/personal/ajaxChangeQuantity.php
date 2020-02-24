<?php

session_start();
include("../connect.php");

$quantity = $mysqli->real_escape_string($_POST['quantity']);
$id = $mysqli->real_escape_string($_POST['id']);

$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
$user = $userResult->fetch_assoc();

if($mysqli->query("UPDATE basket SET quantity = '".$quantity."' WHERE user_id = '".$_SESSION['userID']."' AND good_id = '".$id."'")) {

	$totalNormal = 0;
	$totalAction = 0;

	$basketResult = $mysqli->query("SELECT * FROM basket WHERE user_id = '".$_SESSION['userID']."'");
	while($basket = $basketResult->fetch_assoc()) {
		$active = 0;
		$aID = 0;

		$actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$basket['good_id']."'");
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
				}
			}
		}

		$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$basket['good_id']."'");
		$good = $goodResult->fetch_assoc();

		$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
		$currency = $currencyResult->fetch_assoc();

		if($aID == 0) {
		    if($user['opt'] == 1) {
                $price = $good['price_opt'] * $currency['rate'];
            } else {
                $price = $good['price'] * $currency['rate'];
            }

			$totalNormal += $price * $basket['quantity'];
		} else {
			$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$basket['good_id']."' AND action_id = '".$aID."'");
			$actionGood = $actionGoodResult->fetch_assoc();

			$price = $actionGood['price'] * $currency['rate'];
			$totalAction += $price * $basket['quantity'];
		}
	}

	$total = $totalAction + $totalNormal * (1 - $user['discount'] / 100);
	$roubles = floor($total);
	$kopeck = ceil(($total - $roubles) * 100);

	if($kopeck == 100) {
		$kopeck = 0;
		$roubles++;
	}

	if($roubles == 0) {
		$total = $kopeck." коп.";
	} else {
		$total = $roubles." руб. ".$kopeck." коп.";
	}

	echo $total;
}