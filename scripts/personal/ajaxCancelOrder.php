<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../../index.php");
}

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
if($mysqli->query("DELETE FROM orders_info WHERE id = '".$id."'")) {
	$mysqli->query("DELETE FROM orders_comments WHERE order_id = '".$id."'");

	if($mysqli->query("DELETE FROM orders WHERE order_id = '".$id."'")) {
		$ordersQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '0'");
		$ordersQuantity = $ordersQuantityResult->fetch_array(MYSQLI_NUM);

		if($ordersQuantity[0] == 0) {
			echo "<span style='font-size: 15px;'><b>На данный момент у вас нет активных заявок.</b></span>";
		} else {
			$j = 0;
			$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '0'");
			echo "
				<p>Активные заявки — это заказы, которые ещё не обработаны менеджером. До момента принятия заказа вы вправе редактировать свои заказы. Для этого нажмите на соответствующий номер заказа, выделенный красным цветом.</p>
				<table style='width: 100%; text-align: center;'>
					<tr class='headTR'>
						<td>№</td>
						<td>Заказ</td>
						<td>Дата оформления</td>
						<td>Отмена заказа</td>
					</tr>
			";
			while($order = $orderResult->fetch_assoc()) {
				$j++;
				echo "
					<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
						<td>".$j."</td>
						<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
						<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
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
	}
}