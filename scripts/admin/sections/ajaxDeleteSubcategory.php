<?php

include("../../connect.php");

$req = false;
ob_start();

$goodSubcategory = $mysqli->real_escape_string($_POST['goodSubcategory']);
$goodSubcategory2 = $mysqli->real_escape_string($_POST['goodSubcategory2']);
$checkbox = $mysqli->real_escape_string($_POST['deleteGoods']);

if($checkbox == "on") {
	//удалить все дочерние подразделы и товары

	if(!empty($goodSubcategory2)) {
		//если удаляется subcategory2

		$count = 0;
		$success = 0;

		$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$goodSubcategory2."'");
		while($good = $goodResult->fetch_assoc()) {
			$count++;

			if($mysqli->query("DELETE FROM catalogue_new WHER id = '".$good['id']."'")) {
				unlink("../../../img/catalogue/big/".$good['picture']);
				unlink("../../../img/catalogue/small/".$good['small']);

				if(!empty($good['sketch'])) {
					unlink("../../../img/catalogue/sketch/".$good['sketch']);
				}

				$success++;
			}
		}

		if($mysqli->query("DELETE FROM subcategories2 WHERE id = '".$goodSubcategory2."'")) {
			if($success > 0) {
				if($count == $success) {
					echo "ok";
				} else {
					echo "okGoodsPartly";
				}
			} else {
				echo "okGoodsFailed";
			}
		} else {
			if($success > 0) {
				if($count == 0) {
					echo "failedGoodsOk";
				} else {
					echo "failedGoodsPartly";
				}
			} else {
				echo "failed";
			}
		}
	} else {
		//если удаляется subcategory

		$subCount = 0;
		$subSuccess = 0;

		$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$goodSubcategory."'");
		while($subcategory2 = $subcategory2Result->fetch_assoc()) {
			$goodCount = 0;
			$goodSuccess = 0;
			$subCount++;

			$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$subcategory2['id']."'");
			while($good = $goodResult->fetch_assoc()) {
				$goodCount++;

				if($mysqli->query("DELETE FROM catalogue_new WHERE id = '".$good['id']."'")) {
					unlink("../../../img/catalogue/big/".$good['picture']);
					unlink("../../../img/catalogue/small/".$good['small']);

					if(!empty($good['sketch'])) {
						unlink("../../../img/catalogue/sketch/".$good['sketch']);
					}

					$goodSuccess++;
				}
			}

			if($mysqli->query("DELETE FROM subcategories2 WHERE id = '".$subcategory2['id']."'")) {
				$subSuccess++;
			}
		}

		if($mysqli->query("DELETE FROM subcategories_new WHERE id = '".$goodSubcategory."'")) {
			if($subSuccess > 0) {
				if($subCount == $subSuccess) {
					if($goodSuccess > 0) {
						if($goodCount == $goodSuccess) {
							echo "ok";
						} else {
							echo "okSubOkGoodsPartly";
						}
					} else {
						echo "okSubOkGoodsFailed";
					}
				} else {
					if($goodSuccess > 0) {
						if($goodCount == $goodSuccess) {
							echo "okSubPartlyGoodsOk";
						} else {
							echo "okSubPartlyGoodsPartly";
						}
					} else {
						echo "okSubPartlyGoodsFailed";
					}
				}
			} else {
				if($goodSuccess > 0) {
					if($goodCount == $goodSuccess) {
						echo "okSubFailedGoodsOk";
					} else {
						echo "okSubFailedGoodsPartly";
					}
				} else {
					echo "okSubFailedGoodsFailed";
				}
			}
		} else {
			if($subSuccess > 0) {
				if($subCount == $subSuccess) {
					if($goodSuccess > 0) {
						if($goodCount == $goodSuccess) {
							echo "failedSubOkGoodsOk";
						} else {
							echo "failedSubOkGoodsPartly";
						}
					} else {
						echo "failedSubOkGoodsFailed";
					}
				} else {
					if($goodSuccess > 0) {
						if($goodCount == $goodSuccess) {
							echo "failedSubPartlyGoodsOk";
						} else {
							echo "failedSubPartlyGoodsPartly";
						}
					} else {
						echo "failedSubPartlyGoodsFailed";
					}
				}
			} else {
				if($goodSuccess > 0) {
					if($goodCount == $goodSuccess) {
						echo "failedSubFailedGoodsOk";
					} else {
						echo "failedSubFailedGoodsPartly";
					}
				} else {
					echo "failed";
				}
			}
		}
	}
} else {
	//удалить все дочерние подразделы, удалить у товаров соответствующую subcategory или subcategory2, оставить их в родительском разделе

 	if(!empty($goodSubcategory2)) {
		//если удаляется subcategory2
		if($mysqli->query("DELETE FROM subcategories2 WHERE id = '".$goodSubcategory2."'")) {
			echo "ok";
		} else {
			echo "failed";
		}
	} else {
		//если удаляется subcategory

		$count = 0;
		$success = 0;

		$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$goodSubcategory."'");
		while($subcategory2 = $subcategory2Result->fetch_assoc()) {
			$count++;

			if($mysqli->query("DELETE FROM subcategories2 WHERE id = '".$subcategory2['id']."'")) {
				$success++;
			}
		}

		if($mysqli->query("DELETE FROM subcategories_new WHERE id = '".$goodSubcategory."'")) {
			if($success > 0) {
				if($count == $success) {
					echo "ok";
				} else {
					echo "okPartly";
				}
			} else {
				echo "okSubFailed";
			}
		} else {
			if($success > 0) {
				if($count == $success) {
					echo "failedSubOk";
				} else {
					echo "failedPartly";
				}
			} else {
				echo "failed";
			}
		}
	}
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;