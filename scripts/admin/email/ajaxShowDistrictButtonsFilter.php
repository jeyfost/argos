<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 28.11.2017
 * Time: 8:22
 */

include("../../connect.php");

$district = $mysqli->real_escape_string($_POST['district']);
$group = $mysqli->real_escape_string($_POST['group']);

$clientsCountResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE location = '".$district."' AND filter = '".$group."' AND in_send = '1'");
$clientsCount = $clientsCountResult->fetch_array(MYSQLI_NUM);

$buttonsCount = intval($clientsCount[0] / 10);

if(($clientsCount[0] - $buttonsCount) > 0) {
	$buttonsCount++;
}

echo "
	<br /><br />
	<label>Отправить письмо по группам:</label>
	<br />
";

for($i = 0; $i < $buttonsCount; $i++) {
	if($clientsCount[0] < $i * 10 + 10) {
		$j = $clientsCount[0];
	} else {
		$j = $i * 10 + 10;
	}

	if($j - ($i * 10 + 1) == 0) {
		$to = $j;
	} else {
		$to = $to = ($i * 10 + 1)." — ".$j;;
	}

	echo "<div class='districtButton' id='db".$i."' onclick='sendFilterEmail(\"".$i."\")'><span>".$to."</span></div>";
}

if($clientsCount[0] == 0) {
	echo "<span style='color: #df4e47;'>Не найдено ни одного предприятия с выбранными критериями.</span>";
}

echo "<div style='clear: both;'></div>";