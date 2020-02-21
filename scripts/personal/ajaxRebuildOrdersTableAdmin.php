<?php

session_start();
include("../connect.php");

$orderID = $mysqli->real_escape_string($_POST['orderID']);

$userIDResult = $mysqli->query("SELECT user_id FROM orders_info WHERE id = '".$orderID."'");
$userID = $userIDResult->fetch_array(MYSQLI_NUM);

$ordersQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
$ordersQuantity = $ordersQuantityResult->fetch_array(MYSQLI_NUM);

if($ordersQuantity[0] == 0) {
	echo "<span style='font-size: 15px;'><b>На данный момент необработанных заявок нет.</b></span>";
} else {
	$j = 0;
	$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '0'");

	echo "
		<p>Активные заявки — это заказы, которые ещё не были утверждены. До момента принятия заказа необходимо созвониться с клиентом для подтверждения и уточнения итоговой стоимости. </p>
		<form method='post'>
			<label for='clientSelect'>Клиент:</label>
			<br />
			<select id='clientSelect' onchange='selectClient(\"ajaxSelectClient\")'>
				<option value='all' selected>- Все клиенты -</option>
	";

	$clientIDResult = $mysqli->query("SELECT DISTINCT user_id FROM orders_info WHERE status = '0'");
	while($clientID = $clientIDResult->fetch_array(MYSQLI_NUM)) {
		$clientResult = $mysqli->query("SELECT * FROM users WHERE id = '".$clientID[0]."'");
		$client = $clientResult->fetch_assoc();
		echo "<option value='".$clientID[0]."'>"; if(!empty($client['company'])) {echo $client['company']." — ";} echo $client['name']; echo "</option>";
	}
	echo "
			</select>
		</form>
		<br /><br />
		<div id='orderResponse'></div>
		<table style='min-width: 100%; text-align: center;' id='ordersTable'>
			<tr class='headTR'>
				<td>№</td>
				<td>Заказ</td>
				<td>Дата оформления</td>
				<td>Клиент</td>
				<td>Детализация заказа</td>
				<td>Отмена заказа</td>
			</tr>
	";

	while($order = $orderResult->fetch_assoc()) {
		$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
		$user = $userResult->fetch_assoc();
		$j++;

		echo "
			<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
				<td>".$j."</td>
				<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
				<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
				<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
				<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")'>Открыть детализацию</span></td>
				<td><span class='tdLink' onclick='cancelOrder(\"".$order['id']."\")'>Отменить заказ</span></td>
			</tr>
		";
	}

	echo "
		</table>
		<br /><br />
		<div id='responseField'></div>
	";
}