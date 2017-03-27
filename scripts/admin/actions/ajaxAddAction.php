<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 24.03.2017
 * Time: 13:15
 */

include("../../connect.php");
include("../../simpleImage.php");

function randomName($tmp_name) {
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

$req = false;
ob_start();

$header = $mysqli->real_escape_string($_POST['header']);
$from_date = $mysqli->real_escape_string($_POST['from']);
$to_date = $mysqli->real_escape_string($_POST['to']);
$from = strtotime($from_date);
$to = strtotime($to_date);
$today = strtotime(date('d-m-Y'));
$goodsID = explode(",", $_POST['goodsID']);
$goodsPrice = explode(",", $_POST['goodsPrice']);

if($from <= $to) {
	$zeroCheck = 0;

	if(count($goodsID) > 0) {
		for($i = 0; $i < count($goodsID); $i++) {
			if(empty($goodsID[$i])) {
				$zeroCheck++;
			}
		}
	}

	if(count($goodsID) != $zeroCheck) {
		//если акция с конкретными товарами

		$goods = array();
		$prices = array();
		$indexes = array();
		$zeroPrices = 0;

		for($i = 0; $i < count($goodsID); $i++) {
			//создать массивы с акционными ценами и id товаров, убрать дубликаты
			$check = 0;

			for($j = 0; $j < count($goods); $j++) {
				if($goods[$j] == $goodsID[$i]) {
					$check = 1;
				}
			}

			if($check == 0) {
				array_push($indexes, $i);
				array_push($goods, $goodsID[$i]);
			}
		}

		for($i = 0; $i < count($indexes); $i++) {
			array_push($prices, $goodsPrice[$indexes[$i]]);
		}

		for($i = 0; $i < count($prices); $i++) {
			//все ли цены введены?
			if(empty($prices[$i]) or $prices[$i] == 0) {
				$zeroPrices++;
			}
		}

		if($zeroPrices == 0) {
			if(checkdate((int)substr($from_date, 3, 2), (int)substr($from_date, 0, 2), (int)substr($from_date, 6)) and strlen($from_date) == 10) {
				if(checkdate((int)substr($to_date, 3, 2), (int)substr($to_date, 0, 2), (int)substr($to_date, 6)) and strlen($to_date) == 10) {
					$maxActionIDResult = $mysqli->query("SELECT MAX(id) FROM actions");
					$maxActionID = $maxActionIDResult->fetch_array(MYSQLI_NUM);

					$newActionID = $maxActionID[0] + 1;

					$previewName = randomName($_FILES['previewPhoto']['tmp_name']);
					$previewDBName = $previewName.".".substr($_FILES['previewPhoto']['name'], count($_FILES['previewPhoto']['name']) - 4, 4);
					$previewUploadDir = '../../../img/photos/actions/';
					$previewTmpName = $_FILES['previewPhoto']['tmp_name'];
					$previewUpload = $previewUploadDir.$previewDBName;

					if($mysqli->query("INSERT INTO actions (id, date, year, header, preview, text, from_date, to_date) VALUES('".$newActionID."', '".date('d-m-Y')."', '".date('Y')."', '".$header."', '".$previewDBName."', '".$_POST['newsText']."', '".$from_date."', '".$to_date."')")) {
						$img = new SimpleImage($previewTmpName);
						$img->resizeToWidth(200);
						$img->save($previewUpload);

						$goodsCount = 0;

						for($i = 0; $i < count($goods); $i++) {
							$goodID = $goods[$i];
							$forbidden = 0;

							$goodActionResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$goodID."'");
							while($goodAction = $goodActionResult->fetch_assoc()) {
								$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$goodAction['action_id']."'");
								$action = $actionResult->fetch_assoc();

								//если акция действующая
								if(strtotime($action['from_date']) <= $today and strtotime($action['to_date']) >= $today) {
									$forbidden = 1;
								}

								//если рамки проведения новой акции пересакаются с запланированными
								if($from < strtotime($action['from_date']) and ($to >= strtotime($action['from_date']) and $to < strtotime($action['to_date']))) {
									$forbidden = 1;
								}

								if($from >= strtotime($action['from_date']) and $to <= strtotime($action['to_date'])) {
									$forbidden = 1;
								}

								if($from >= strtotime($action['from_date']) and ($to > strtotime($action['to_date']))) {
									$forbidden = 1;
								}
							}

							if($forbidden == 0) {
								$currencyResult = $mysqli->query("SELECT currency FROM catalogue_new WHERE id = '".$goodID."'");
								$currency = $currencyResult->fetch_array(MYSQLI_NUM);

								if($mysqli->query("INSERT INTO action_goods (action_id, good_id, price, currency) VALUES ('".$newActionID."', '".$goodID."', '".$prices[$i]."', '".$currency[0]."')")) {
									$goodsCount++;
								}
							}
						}

						if($goodsCount == count($goods)) {
							echo "ok";
						} else {
							echo "goods";
						}
					}
				} else {
					echo "to";
				}
			} else {
				echo "from";
			}
		} else {
			echo "prices";
		}
	} else {
		if(checkdate((int)substr($from_date, 3, 2), (int)substr($from_date, 0, 2), (int)substr($from_date, 6)) and strlen($from_date) == 10) {
			if (checkdate((int)substr($to_date, 3, 2), (int)substr($to_date, 0, 2), (int)substr($to_date, 6)) and strlen($to_date) == 10) {
				$maxActionIDResult = $mysqli->query("SELECT MAX(id) FROM actions");
				$maxActionID = $maxActionIDResult->fetch_array(MYSQLI_NUM);

				$newActionID = $maxActionID[0] + 1;

				$previewName = randomName($_FILES['previewPhoto']['tmp_name']);
				$previewDBName = $previewName . "." . substr($_FILES['previewPhoto']['name'], count($_FILES['previewPhoto']['name']) - 4, 4);
				$previewUploadDir = '../../../img/photos/actions/';
				$previewTmpName = $_FILES['previewPhoto']['tmp_name'];
				$previewUpload = $previewUploadDir . $previewDBName;

				if ($mysqli->query("INSERT INTO actions (id, date, year, header, preview, text, from_date, to_date) VALUES('" . $newActionID . "', '" . date('d-m-Y') . "', '" . date('Y') . "', '" . $header . "', '" . $previewDBName . "', '" . $_POST['newsText'] . "', '" . $from_date . "', '" . $to_date . "')")) {
					$img = new SimpleImage($previewTmpName);
					$img->resizeToWidth(200);
					$img->save($previewUpload);

					echo "ok";
				} else {
					echo "failed";
				}
			} else {
				echo "to";
			}
		} else {
			echo "from";
		}
	}
} else {
	echo "time";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;