<?php

include("../connect.php");
include("../helpers.php");

$id = $mysqli->real_escape_string($_POST['client']);
$j = 0;

if($id == "all") {
	$orderCountResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '0'");
} else {
	$orderCountResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '0' AND user_id = '".$id."'");
}

$orderCount = $orderCountResult->fetch_array(MYSQLI_NUM);
if($orderCount[0] > 0) {
	if($id == "all") {
		echo "
			<tr class='headTR'>
				<td>№</td>
				<td>Заказ</td>
				<td style='cursor: default;'><i class='fa fa-folder-open-o' aria-hidden='true'></i></td>
				<td>Дата оформления</td>
				<td>Клиент</td>
				<td>Принять заказ</td>
				<td>Отмена заказа</td>
			</tr>
		";
		$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '0'");
		while($order = $orderResult->fetch_assoc()) {
			$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
			$user = $userResult->fetch_assoc();
			$j++;
			echo "
				<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
					<td>".$j."</td>
					<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
					<td><a href='/personal/order.php?id=".$order['id']."' target='_blank' class='font-awesome-link' title='Открыть детализацию заказа в новом окне'><i class='fa fa-folder-open-o' aria-hidden='true'></i></a></td>
					<td>".dateFormattedDayToYear($order['send_date'])."</td>
					<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
					<td><span class='tdLink' onclick='acceptOrder(\"".$order['id']."\")'>Принять заказ</span></td>
					<td><span class='tdLink' onclick='cancelOrder(\"".$order['id']."\")'>Отменить заказ</span></td>
				</tr>
			";
		}
	} else {
		echo "
			<tr class='headTR'>
				<td>№</td>
				<td>Заказ</td>
				<td style='cursor: default;'><i class='fa fa-folder-open-o' aria-hidden='true'></i></td>
				<td>Дата оформления</td>
				<td>Клиент</td>
				<td>Принять заказ</td>
				<td>Отмена заказа</td>
			</tr>
		";
		$userCheckResult = $mysqli->query("SELECT * FROM users WHERE id = '".$id."'");
		if($userCheckResult->num_rows > 0) {
			$user = $userCheckResult->fetch_assoc();
			$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '0' AND user_id = '".$id."'");
			while($order = $orderResult->fetch_assoc()) {
				$j++;
				echo "
					<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
						<td>".$j."</td>
						<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
						<td><a href='/personal/order.php?id=".$order['id']."' target='_blank' class='font-awesome-link' title='Открыть детализацию заказа в новом окне'><i class='fa fa-folder-open-o' aria-hidden='true'></i></a></td>
						<td>".dateFormattedDayToYear($order['send_date'])."</td>
						<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
						<td><span class='tdLink' onclick='acceptOrder(\"".$order['id']."\")'>Принять заказ</span></td>
						<td><span class='tdLink' onclick='cancelOrder(\"".$order['id']."\")'>Отменить заказ</span></td>
					</tr>
				";
			}
		}
	}
} else {
	echo "b";
}