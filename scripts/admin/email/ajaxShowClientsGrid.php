<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.04.2017
 * Time: 8:54
 */

include("../../connect.php");

$req = false;
ob_start();

$location = $mysqli->real_escape_string($_POST['district']);

if($location != '') {
	echo "
		<br /><br />
		<label>Выберите клиентов, которым нужно отправить письмо:</label>
		<br /><br />
	";
	$clientResult = $mysqli->query("SELECT * FROM clients WHERE location = '".$location."' AND in_send = '1' ORDER BY name");
	while($client = $clientResult->fetch_assoc()) {
		echo "
			<div class='clientBlock'>
				<div class='clientCheckbox'>
					<input type='checkbox' class='checkbox' name='client' value='".$client['id']."' title='Выбрать' />
				</div>
				<div class='client'>".$client['name']."<br />".$client['email']."</div>
				<div style='clear: both;'></div>
			</div>
		";
	}

	echo "<div style='clear: both;'></div>";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;