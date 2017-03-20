<?php

include("../../connect.php");

$req = false;
ob_start();

$goodCategory = $mysqli->real_escape_string($_POST['goodCategory']);
$checkbox = $mysqli->real_escape_string($_POST['deleteGoods']);

$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '".$goodCategory."'");
$category = $categoryResult->fetch_assoc();

$subcategoriesCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$goodCategory."'");
$subcategoriesCheck = $subcategoriesCheckResult->fetch_array(MYSQLI_NUM);

if($checkbox == "on") {
	//удалить все дочерние подразделы и товары

	$count = 0;
	$success = 0;
	$message = "";

	if($subcategoriesCheck[0] > 0) {
		// если в разделе есть подразделы

		$count = $subcategoriesCheck[0];

		$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$goodCategory."'");
		while($subcategory = $subcategoryResult->fetch_assoc()) {
			$subcategories2CheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
			$subcategories2Check = $subcategories2CheckResult->fetch_array(MYSQLI_NUM);

			if($subcategories2Check[0] > 0) {
				// если в подразделе есть подразделы 2-го уровня

				$count += $subcategories2Check[0];

				$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
				while($subcategory = $subcategory2Result->fetch_assoc()) {
					if($mysqli->query("DELETE FROM subcategories2 WHERE id = '".$subcategory2['id']."'")) {
						$success++;
					}
				}

				if($mysqli->query("DELETE FROM subcategories_new WHERE id = '".$subcategory['id']."'")) {
					$count++;
				}
			} else {
				if($mysqli->query("DELETE FROM subcategories_new WHERE id = '".$subcategory['id']."'")) {
					$count++;
				}
			}
		}

		if($mysqli->query("DELETE FROM categories_new WHERE id = '".$goodCategory."'")) {
			unlink("../../../img/icons/".$category['picture']);
			unlink("../../../img/icons/".$category['picture_red']);

			if($count > 0) {
				if($success > 0) {
					if($count == $success) {
						$message = "ok";
					} else {
						$message = "okSubPartly";
					}
				} else {
					$message = "okSubFailed";
				}
			} else {
				$message = "ok";
			}
		} else {
			$message = "failed";
		}
	} else {
		// если в разделе нет подразделов

		if($mysqli->query("DELETE FROM categories_new WHERE id = '".$goodCategory."'")) {
			unlink("../../../img/icons/".$category['picture']);
			unlink("../../../img/icons/".$category['picture_red']);

			$message = "ok";
		} else {
			$message = "failed";
		}
	}

	$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE category = '".$goodCategory."'");
	$goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

	if($goodsCount[0] > 0) {
		$goodCount = 0;
		$goodSuccess = 0;

		$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$goodCategory."'");
		while($good = $goodResult->fetch_assoc()) {
			if($mysqli->query("DELETE FROM catalogue_new WHERE id = '".$good['id']."'")) {
				$goodSuccess++;

				unlink("../../../img/catalogue/big/".$good['picture']);
				unlink("../../../img/catalogue/small/".$good['small']);
			}
		}

		if($goodSuccess > 0) {
			if($goodsCount == $goodSuccess) {
				$message .= "GoodsOk";
			} else {
				$message .= "GoodsPartly";
			}
		} else {
			$message .= "GoodsFailed";
		}

		echo $message;
	} else {
		echo $message;
	}
} else {
	//удалить все дочерние подразделы, удалить у товаров соответствующую subcategory или subcategory2, оставить их в родительском разделе

	if($subcategoriesCheck[0] > 0) {
		// если в разделе есть подразделы

		$count = $subcategoriesCheck[0];
		$success = 0;

		$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$goodCategory."'");
		while($subcategory = $subcategoryResult->fetch_assoc()) {

			$subcategories2CheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
			$subcategories2Check = $subcategories2CheckResult->fetch_array(MYSQLI_NUM);

			if($subcategories2Check[0] > 0) {
				$count += $subcategories2Check[0];

				$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
				while($subcategory2 = $subcategory2Result->fetch_assoc()) {
					if($mysqli->query("DELETE FROM subcategories2 WHERE id = '".$subcategory2['id']."'")) {
						$success++;
					}
				}
			}

			if($mysqli->query("DELETE FROM subcategories_new WHERE id = '".$subcategory['id']."'")) {
				$success++;
			}
		}

		if($mysqli->query("DELETE FROM categories_new WHERE id = '".$goodCategory."'")) {
			unlink("../../../img/icons/".$category['picture']);
			unlink("../../../img/icons/".$category['picture_red']);

			if($success > 0) {
				if($count == $success) {
					echo "ok";
				} else {
					echo "okSubPartly";
				}
			} else {
				echo "okSubFailed";
			}
		} else {
			if($success > 0) {
				if($count == $success) {
					echo "failedSubOk";
				} else {
					echo "failedSubPartly";
				}
			} else {
				echo "failed";
			}
		}
	} else {
		// если в разделе нет подразделов

		if($mysqli->query("DELETE FROM categories_new WHERE id = '".$goodCategory."'")) {
			unlink("../../../img/icons/".$category['picture']);
			unlink("../../../img/icons/".$category['picture_red']);

			echo "ok";
		} else {
			echo "failed";
		}
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;