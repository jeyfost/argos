<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 02.04.2018
 * Time: 18:20
 */

session_start();
include("../connect.php");
include("../helpers.php");

$query = $mysqli->real_escape_string($_POST['query']);

$searchResult = $mysqli->query("SELECT * FROM orders_info WHERE (id LIKE '%".$query."%' OR send_date LIKE '%".$query."%') AND user_id = '".$_SESSION['userID']."' AND status = '0' ORDER BY id LIMIT 10");

if($searchResult->num_rows == 0) {
    echo "<i>К сожалению, поиск не дал результата.</i>";
} else {
    $j = 0;

    while($search = $searchResult->fetch_assoc()) {
        $j++;

        echo "
			<div class='searchItem'"; if($j % 2 == 0) {echo " style='background-color: #d9d9d9;'";} echo ">
			    <a href='/personal/order.php?id=".$search['id']."' target='_blank'><span class='catalogueNameLink'>Заказ №".$search['id']." от ".dateFormattedDayToYear($search['send_date'])."</span></a>
			</div>
		";
    }
}