<?php

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['userID']);
$j = 0;

if($id == "all") {
	$orderCountResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '1'");
} else {
	$orderCountResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '1' AND user_id = '".$id."'");
}

$start = $_POST['page'] * 10 - 10;
$orderCount = $orderCountResult->fetch_array(MYSQLI_NUM);
if($orderCount[0] > 0) {
	if($id == "all") {
		echo "
			<tr class='headTR'>
				<td>№</td>
				<td>Заказ</td>
				<td>Клиент</td>
				<td>Дата оформления</td>
				<td>Дата принятия</td>
			</tr>
		";
		$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '1' ORDER BY id DESC LIMIT ".$start.", 10");
		while($order = $orderResult->fetch_assoc()) {
			$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
			$user = $userResult->fetch_assoc();
			$j++;
			echo "
				<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
					<td>".($start + $j)."</td>
						<td><span class='tdLink' onclick='showOrderDetailsHistory(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
						<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
						<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
						<td>".substr($order['proceed_date'], 0, 10)." в ".substr($order['proceed_date'], 11, 8)."</td>
				</tr>
			";
		}
	} else {
		echo "
			<tr class='headTR'>
				<td>№</td>
				<td>Заказ</td>
				<td>Клиент</td>
				<td>Дата оформления</td>
				<td>Дата принятия</td>
			</tr>
		";
		$userCheckResult = $mysqli->query("SELECT * FROM users WHERE id = '".$id."'");
		if($userCheckResult->num_rows > 0) {
			$user = $userCheckResult->fetch_assoc();
			$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '1' AND user_id = '".$id."' ORDER BY id DESC LIMIT ".$start.", 10");
			while($order = $orderResult->fetch_assoc()) {
				$j++;
				echo "
					<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
						<td>".($start + $j)."</td>
						<td><span class='tdLink' onclick='showOrderDetailsHistory(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
						<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
						<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
						<td>".substr($order['proceed_date'], 0, 10)." в ".substr($order['proceed_date'], 11, 8)."</td>
					</tr>
				";
			}
		}
	}
}