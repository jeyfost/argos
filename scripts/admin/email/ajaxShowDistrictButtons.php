<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 15:08
 */

include("../../connect.php");

$req = false;
ob_start();

$location = $mysqli->real_escape_string($_POST['district']);

if($location != '') {
	$clientsCountResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE location = '".$location."'");
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

		echo "<div class='districtButton' id='db".$i."' onclick='sendDistrictEmail(\"".$i."\")'><span>".$to."</span></div>";
	}

	echo "<div style='clear: both;'></div>";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;