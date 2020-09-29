<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$employee = $mysqli->real_escape_string($_POST['employee']);

$userResult = $mysqli->query("SELECT user_id FROM orders_info WHERE id = '".$id."'");
$user = $userResult->fetch_array(MYSQLI_NUM);

$customerResult = $mysqli->query("SELECT * FROM users WHERE id = '".$user[0]."'");
$customer = $customerResult->fetch_assoc();

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

$total = $totalAction + $totalNormal / ($customer['discount'] / 100 + 1);
$roubles = floor($total);
$kopeck = ceil(($total - $roubles) * 100);

if($kopeck == 100) {
	$kopeck = 0;
	$roubles++;
}

if($kopeck < 10) {
	$kopeck = "0".$kopeck;
}

$total = $roubles.".".$kopeck;

$goods = array();
$i = 0;

$orderItemResult = $mysqli->query("SELECT * FROM orders WHERE order_id = '".$id."'");
while($orderItem = $orderItemResult->fetch_assoc()) {
	$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$orderItem['good_id']."'");
	$good = $goodResult->fetch_assoc();

	$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['id']."'");
	$unit = $unitResult->fetch_assoc();

	$goods[$i]['good'] = $good;
	$goods[$i]['order'] = $orderItem;
	$goods[$i]['unit'] = $unit;
	$i++;
}

if($mysqli->query("UPDATE orders_info SET summ = '".$total."', proceed_date = '".date('d-m-Y H:i:s')."', status = '1', manager = '".$employee."' WHERE id = '".$id."'")) {
    $employeeResult = $mysqli->query("SELECT * FROM employees WHERE id = '".$employee."'");
    $employee = $employeeResult->fetch_assoc();

    $name = $employee['name'];
    $phone = $employee['phone'];

	sendMail($customer['email'], $id, $goods, $total, $name, $phone);

	echo "a";
} else {
	echo "b";
}

function sendMail($email, $id, $goods, $summ, $name, $phone) {
	$from = "ЧТУП Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Заказ №".$id." был принят";

	$hash = md5(rand(0, 1000000).date('Y-m-d H:i:s'));

	$headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
	$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

	$text = "
		<div style='width: 100%; height: 100%; background-color: #fafafa; padding-top: 5px; padding-bottom: 20px;'>
			<center>
				<div style='width: 600px; text-align: left;'>
					<a href='https://argos-fm.by/' target='_blank'><img src='https://argos-fm.by/img/system/logo.png' /></a>
				</div>
				<br />
				<div style='padding: 20px; box-shadow: 0 5px 15px -4px rgba(0, 0, 0, 0.4); background-color: #fff; width: 600px; text-align: left;'>
					<p>Ваш заказ №".$id." был принят к сборке. Забрать его вы сможете по адресу: г. Могилёв, ул. Залуцкого, д. 21.</p>
					<p>Время работы можно узнать в <a href='https://argos-fm.by/contacts/stores.php' style='color: #ff282b;'>разделе с контактной информацией</a>.</p>
					<br /><br /> 
					<center>
						<b>Детализация заказа</b>
						<br /><br />
						<table style='border-collapse: collapse; text-align: center; vertical-align: middle;'>
							<thead>
								<tr style='background-color: #dcddde; text-align: center; font-weight: bold;'>
									<td style='padding: 10px; border: 1px solid #bdbec0;'>Фото</td>
									<td style='padding: 10px; border: 1px solid #bdbec0;'>Наименование</td>
									<td style='padding: 10px; border: 1px solid #bdbec0;'>Количество</td>
								</tr>
							</thead>
							<tbody>
	";

	foreach ($goods as $good) {
		$text .= "
			<tr>
				<td style='width: 100px; border: 1px solid #bdbec0; border-collapse: collapse;'><img src='https://argos-fm.by/img/catalogue/small/".$good['good']['small']."' /></td>
				<td style='border: 1px solid #bdbec0; border-collapse: collapse;'><b>".$good['good']['name']."</b></td>
				<td style='border: 1px solid #bdbec0; border-collapse: collapse;'>".$good['order']['quantity']." ".$good['unit']['short_name']."</td>
			</tr>
		";
	}

	$text .= "
							</tbody>
						</table>
					</center>
					<br /><br />
					<div style='text-align: center;'><b>Итоговая стоимость заказа: </b>".$summ." руб.</div>
					<br /><br />
					<div style='text-align: center;'><b>Сотрудник, принявший заказ: </b>".$phone.", ".$name."</div>
					<p>Полную детализацию заказа можно посмотреть на <a href='https://argos-fm.by/personal/order.php?id=".$id."' target='_blank' style='color: #ff282b;'>этой странице</a>, предварительно авторизовавшись на сайте.</p>
					<br /><hr /><br />
					<p style='font-size: 12px;'>Это автоматическая рассылка. Отвечать на неё не нужно.</p>
					<div style='width: 100%; height: 10px;'></div>
				</div>
				<br /><br />
			</center>
		</div>
	";

	$message = "--PHP-mixed-".$hash."\n";
	$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	$message .= $text."\n";
	$message .= "--PHP-mixed-".$hash."\n";

	mail($email, $subject, $message, $headers);

	return true;
}