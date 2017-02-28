<?php

include("../../connect.php");

$req = false;
ob_start();

$row = 1;

if(!empty($_FILES['csvFile']['tmp_name'])) {
	$uploadDir = "../../../files/1C/";
	$name = "update.csv";
	$upload = $uploadDir.$name;

	move_uploaded_file($_FILES['csvFile']['tmp_name'], $upload);

	if(($handle = fopen($upload, "r")) !== FALSE) {
		while(($data = fgetcsv($handle, ",")) !== FALSE) {
			$num = count($data);

			for ($c=0; $c < $num; $c++) {
				$stats = explode(";", $data[$c]);
				$code = $stats[0];
				$price = $stats[1];
				$quantity = $stats[2];

				if(!empty($code)) {
					switch(strlen($code)) {
						case 1:
							$code = "000".$code;
							break;
						case 2:
							$code = "00".$code;
							break;
						case 3:
							$code = "0".$code;
							break;
						default: break;
					}

					$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE code = '".$code."'");
					$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

					$i = 0;

					if($goodCheck[0] == 1) {
						if($mysqli->query("UPDATE catalogue_new SET price = '".$price."', quantity = '".$quantity."' WHERE code = '".$code."'")) {
							$i++;
						}
					}
				}
			}
		}

		fclose($handle);
		unlink($upload);

		if($i == $num) {
			echo "ok";
		} else {
			if($i > 0) {
				echo "partly";
			} else {
				echo "failed";
			}
		}
	} else {
		echo "failed";
	}
} else {
	echo "failed";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;