<?php

session_start();

if($_SESSION['userID'] != 1) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$userResult = $mysqli->query("SELECT * FROM users WHERE id = (SELECT user_id FROM orders_info WHERE id = '".$id."')");
$user = $userResult->fetch_assoc();

$adminResult = $mysqli->query("SELECT * FROM users WHERE id = '1'");
$admin = $adminResult->fetch_assoc();

$orderSummResult = $mysqli->query("SELECT summ FROM orders_info WHERE id = '".$id."'");
$orderSumm = $orderSummResult->fetch_array(MYSQLI_NUM);

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

if($mysqli->query("DELETE FROM orders_info WHERE id = '".$id."'")) {
	if($mysqli->query("DELETE FROM orders WHERE order_id = '".$id."'")) {
		sendMail($user['email'], $id, $admin, $goods, $orderSumm[0]);

		echo "a";
	} else {
		echo "b";
	}
} else {
	echo "b";
}

function sendMail($email, $id, $admin, $goods, $summ) {
	$from = "ЧТУП Аргос-ФМ <no-reply@argos-fm.by>";
	$reply = "no-reply@argos-fm.by";
	$subject = "Заказ №".$id." был отклонён";

	$hash = md5(rand(0, 1000000).date('Y-m-d H:i:s'));

	$headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
	$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

	$text = "
		<div style='width: 100%; height: 100%; background-color: #fafafa; padding-top: 5px; padding-bottom: 20px; color: #4c4c4c;'>
			<center>
				<div style='width: 600px; text-align: left;'>
					<a href='https://argos-fm.by/' target='_blank'><img src='https://argos-fm.by/img/system/logo.png' /></a>
				</div>
				<br />
				<div style='padding: 20px; box-shadow: 0 5px 15px -4px rgba(0, 0, 0, 0.4); background-color: #fff; width: 600px; text-align: left;'>
					<p style='text-align: center;'>Ваш заказ №".$id." был отклонён. Для уточнения деталей свяжитесь с нами по телефону ".$admin['phone']." или отправьте письмо по адресу <a href='mailto:".$admin['email']."' style='color: #df4e47;'>".$admin['email']."</a>.</p>
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