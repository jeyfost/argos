<?php

include("../../connect.php");

$req = false;
ob_start();

$row = 1;

if(!empty($_FILES['csvFile']['tmp_name'])) {
    /* Первая колонка в файле [0] — артикул, вторая [1] — цена оптовая, третья [2] — цена розничная, четвертая [3] - единицы измерения, пятая [4] — количество в остатке */

	$uploadDir = "../../../files/1C/";
	$name = "update.csv";
	$upload = $uploadDir.$name;

	move_uploaded_file($_FILES['csvFile']['tmp_name'], $upload);

	if(($handle = fopen($upload, "r")) !== FALSE) {
	    if($_POST['zero'] == 1) {
	        $mysqli->query("UPDATE catalogue_new SET quantity = 0");
        }

		while(($data = fgetcsv($handle, ",")) !== FALSE) {
			$num = count($data);

			for ($c = 0; $c < $num; $c++) {
				$stats = explode(";", $data[$c]);
				$code = $stats[0];
				$price = str_replace(" ", "", str_replace(",", ".", $stats[2]));
				$price_opt = str_replace(" ", "", str_replace(",", ".", $stats[1]));
				$unit = $stats[3];
				$quantity = str_replace(",", ".", $stats[4]);

				if(!empty($price) and $price > 0 and !empty($price_opt) and $price_opt > 0) {
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

                        if($goodCheck[0] > 0) {
                            if($mysqli->query("UPDATE catalogue_new SET price = '".$price."', price_opt = '".$price_opt."', quantity = '".$quantity."' WHERE code = '".$code."'")) {
                                $i++;

                                $dbUnitCheckResult = $mysqli->query("SELECT COUNT(id) FROM units WHERE short_name = '".$unit."'");
                                $dbUnitCheck = $dbUnitCheckResult->fetch_array(MYSQLI_NUM);

                                if($dbUnitCheck[0] > 0) {
                                    $dbUnitResult = $mysqli->query("SELECT * FROM units WHERE short_name = '".$unit."'");
                                    $dbUnit = $dbUnitResult->fetch_assoc();

                                    $mysqli->query("UPDATE catalogue_new SET unit = '".$dbUnit['id']."' WHERE code = '".$code."'");
                                }
                            }
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