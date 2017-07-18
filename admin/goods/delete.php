<?php

session_start();
include("../../scripts/connect.php");

if(isset($_SESSION['userID'])) {
	if($_SESSION['userID'] != 1) {
		header("Location: ../../");
	} else {
		$userLoginResult = $mysqli->query("SELECT login from users WHERE id = '".$_SESSION['userID']."'");
		$userLogin = $userLoginResult->fetch_array(MYSQLI_NUM);
	}
} else {
	header("Location: ../index.php");
}

if(!empty($_REQUEST['type'])) {
	$typeCheckResult = $mysqli->query("SELECT COUNT(id) FROM types WHERE catalogue_type = '".$mysqli->real_escape_string($_REQUEST['type'])."'");
	$typeCheck = $typeCheckResult->fetch_array(MYSQLI_NUM);

	if($typeCheck[0] > 0) {
		$t = $mysqli->real_escape_string($_REQUEST['type']);
	} else {
		header("Location: delete.php");
	}
}

if(!empty($_REQUEST['category'])) {
	$cCheckResult = $mysqli->query("SELECT COUNT(id) FROM categories_new WHERE type = '".$t."' AND id = '".$mysqli->real_escape_string($_REQUEST['category'])."'");
	$cCheck = $cCheckResult->fetch_array(MYSQLI_NUM);

	if($cCheck[0] > 0) {
		$c = $mysqli->real_escape_string($_REQUEST['category']);
	} else {
		header("Location: delete.php?type=".$t);
	}
}

if(!empty($_REQUEST['subcategory'])) {
	$sCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$c."' AND id = '".$mysqli->real_escape_string($_REQUEST['subcategory'])."'");
	$sCheck = $sCheckResult->fetch_array(MYSQLI_NUM);

	if($sCheck[0] > 0) {
		$s = $mysqli->real_escape_string($_REQUEST['subcategory']);
	} else {
		header("Location: delete.php?type=".$t."&category=".$c);
	}
}

if(!empty($_REQUEST['subcategory2'])) {
	$s2CheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$s."' AND id = '".$mysqli->real_escape_string($_REQUEST['subcategory2'])."'");
	$s2Check = $s2CheckResult->fetch_array(MYSQLI_NUM);

	if($s2Check[0] > 0) {
		$s2 = $mysqli->real_escape_string($_REQUEST['subcategory2']);
	} else {
		header("Location: delete.php?type=".$t."&category=".$c."&subcategory=".$s);
	}
}

if(!empty($_REQUEST['subcategory2'])) {
	$s2CheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$s."' AND id = '".$mysqli->real_escape_string($_REQUEST['subcategory2'])."'");
	$s2Check = $s2CheckResult->fetch_array(MYSQLI_NUM);

	if($s2Check[0] > 0) {
		$s2 = $mysqli->real_escape_string($_REQUEST['subcategory2']);
	} else {
		header("Location: delete.php?type=".$t."&category=".$c."&subcategory=".$s2);
	}
}

if(!empty($_REQUEST['id'])) {
	if(!empty($_REQUEST['subcategory2'])) {
		$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."' AND subcategory2 = '".$s2."'");
		$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

		if($goodCheck[0] > 0) {
			$id = $mysqli->real_escape_string($_REQUEST['id']);
		} else {
			header("Location: delete.php?type=".$t."&category=".$c."&subcategory=".$s."&subcategory2=".$s2);
		}
	} else {
		if(!empty($_REQUEST['subcategory'])) {
			$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."' AND subcategory = '".$s."'");
			$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

			if($goodCheck[0] > 0) {
				$id = $mysqli->real_escape_string($_REQUEST['id']);
			} else {
				header("Location: delete.php?type=".$t."&category=".$c."&subcategory=".$s);
			}
		} else {
			if(!empty($_REQUEST['category'])) {
				$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."' AND category = '".$c."'");
				$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

				if($goodCheck[0] > 0) {
					$id = $mysqli->real_escape_string($_REQUEST['id']);
				} else {
					header("Location: delete.php?type=".$t."&category=".$c);
				}
			}
		}
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Удаление товаров</title>

    <link rel='shortcut icon' href='../../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../../css/admin.css'>
	<link rel="stylesheet" type="text/css" href="../../js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="../../js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../../js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="../../js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="../../js/common.js"></script>
	<script type="text/javascript" src="../../js/admin/admin.js"></script>
	<script type="text/javascript" src="../../js/admin/goods/delete.js"></script>

	<style>
		#page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
		#page-preloader .spinner {width: 32px; height: 32px; position: absolute; left: 50%; top: 50%; background: url('../../img/system/spinner.gif') no-repeat 50% 50%; margin: -16px 0 0 -16px;}
	</style>

	<script type="text/javascript">
        $(window).on('load', function () {
            var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
            $spinner.delay(500).fadeOut();
            $preloader.delay(850).fadeOut('slow');
        });
    </script>

</head>

<body style="background-color: #e4e4e4;">

	<div id="page-preloader"><span class="spinner"></span></div>

	<div id="menu">
		<div id="logo">
			<a href="../"><img src="../../img/system/logo.png" /></a>
		</div>
		<div class="line"></div>
		<a href="../goods/">
			<div class="menuPointActive">
				<div class="menuIMG"><img src="../../img/system/admin/goods.png" /></div>
				<div class="menuText">Товары</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../sections/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/sections.png" /></div>
				<div class="menuText">Разделы</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../news/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/news.png" /></div>
				<div class="menuText">Новости</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../actions/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/sale.png" /></div>
				<div class="menuText">Акции</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../photo/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/photo.png" /></div>
				<div class="menuText">Фотогалерея</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../albums/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/album.png" /></div>
				<div class="menuText">Альбомы</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../achievements/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/achievement.png" /></div>
				<div class="menuText">Достижения</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../vacancies/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/person.png" /></div>
				<div class="menuText">Вакансии</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../clients/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/clients.png" /></div>
				<div class="menuText">Клиентская база</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../email/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/mail.png" /></div>
				<div class="menuText">Email-рассылки</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../../">
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/home.png" /></div>
				<div class="menuText">Вернуться на сайт</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
	</div>

	<div id="content">
		<div id="top">
			<div id="topText">
				<span style="font-size: 18px; font-weight: bold;">Панель администрирования</span>
				<br />
				<span style="font-size: 14px;">Вы вошли как пользователь <b style="color: #df4e47;"><?php echo $userLogin[0]; ?></b></span>
			</div>
			<a href="../../"><img src="../../img/system/exit.png" id="exitIMG" title="Выйти из панели администрирования" onmouseover="changeIcon('exitIMG', 'exitRed.png', 2)" onmouseout="changeIcon('exitIMG', 'exit.png', 2)" /></a>
		</div>
		<br />
		<div id="admContent">
			<?php
				$goodNameResult = $mysqli->query("SELECT name FROM catalogue_new WHERE id = '".$id."'");
				$goodName = $goodNameResult->fetch_array(MYSQLI_NUM);
			?>
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="../../img/system/admin/icons/product.png" title="Товары" /></div><div id="breadCrumbsTextContainer"><a href="../admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Товары</span></a> > <a href="edit.php"><span class="breadCrumbsText">Удаление товаров</span></a><?php if(!empty($_REQUEST['id'])) {echo " > <a href='".$_SERVER['REQUEST_URI']."'><span class='breadCrumbsText'>".$goodName[0]."</span></a>";} ?></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Редактирование товаров</h2>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" style="margin-left: 0;" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="edit.php"><input type="button" class="button" id="editButton" value="Редактирование" onmouseover="buttonChange('editButton', 1)" onmouseout="buttonChange('editButton', 0)" /></a>
			<a href="delete.php"><input type="button" class="buttonActive" id="deleteButton" value="Удаление" /></a>
			<a href="update.php"><input type="button" class="button" id="correctionButton" value="Выгрузка 1С" onmouseover="buttonChange('correctionButton', 1)" onmouseout="buttonChange('correctionButton', 0)" /></a>
			<a href="codes.php"><input type="button" class="button" id="codesButton" value="Артикулы" onmouseover="buttonChange('codesButton', 1)" onmouseout="buttonChange('codesButton', 0)" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<form id="deleteForm" method="post" enctype="multipart/form-data">
				<label for="typeSelect">Выберите тип товаров:</label>
				<br />
				<select id="typeSelect" name="goodType" onchange="window.location = 'delete.php?type=' + this.options[this.selectedIndex].value">
					<option value="">- Выберите тип товаров -</option>
					<?php
						$typeResult = $mysqli->query("SELECT * FROM types ORDER BY id");
						while($type = $typeResult->fetch_assoc()) {
							echo "<option value='".$type['catalogue_type']."'"; if($_REQUEST['type'] == $type['catalogue_type']) {echo " selected";} echo ">".$type['type_name']."</option>";
						}
					?>
				</select>
				<?php
					if(!empty($_REQUEST['type'])) {
						echo "
							<br /><br />
							<label for='categorySelect'>Выберите раздел:</label>
							<br />
							<select id='categorySelect' name='goodCategory' onchange='selectCategory(\"".$_REQUEST['type']."\", this.options[this.selectedIndex].value)'>
								<option value=''>- Выберите раздел -</option>
						";
						$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$t."' ORDER BY name");
						while ($category = $categoryResult->fetch_assoc()) {
							echo "<option value='".$category['id']."'"; if($c == $category['id']) {echo " selected";} echo ">".$category['name']."</option>";
						}
						echo "</select>";

						if(!empty($_REQUEST['category'])) {
							$subcategoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$c."' ORDER BY name");
							$subcategoryCheck = $subcategoryCheckResult->fetch_array(MYSQLI_NUM);

							if($subcategoryCheck[0] > 0) {
								echo "
									<br /><br />
									<label for='subcategorySelect'>Выберите подраздел:</label>
									<br />
									<select id='subcategorySelect' name='goodSubcategory' onchange='selectSubcategory(\"".$_REQUEST['type']."\", \"".$_REQUEST['category']."\", this.options[this.selectedIndex].value)'>
										<option value=''>- Выберите подраздел -</option>
								";
								$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$c."' ORDER BY name");
								while($subcategory = $subcategoryResult->fetch_assoc()) {
									echo "<option value='".$subcategory['id']."'"; if($s == $subcategory['id']) {echo " selected";} echo ">".$subcategory['name']."</option>";
								}
								echo "</select>";

								if(!empty($_REQUEST['subcategory'])) {
									$subcategory2CheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$s."' ORDER BY name");
									$subcategory2Check = $subcategory2CheckResult->fetch_array(MYSQLI_NUM);

									if($subcategory2Check[0] > 0) {
										echo "
											<br /><br />
											<label for='subcategory2Select'>- Выберите подраздел 2-го уровня:</label>
											<br />
											<select id='subcategory2Select' name='goodSubcategory2' onchange='selectSubcategory2(\"".$_REQUEST['type']."\", \"".$_REQUEST['category']."\", \"".$_REQUEST['subcategory']."\", this.options[this.selectedIndex].value)'>
												<option value=''>- Выберите подраздел 2-го уровня -</option>
										";

										$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$s."' ORDER BY name");
										while($subcategory2 = $subcategory2Result->fetch_assoc()) {
											echo "<option value='".$subcategory2['id']."'"; if($s2 == $subcategory2['id']) {echo " selected";} echo ">".$subcategory2['name']."</option>";
										}

										echo "</select>";

										if(!empty($_REQUEST['subcategory2'])) {
											$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory2 = '".$s2."' ORDER BY name");
											$goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

											if($goodsCount[0] > 0) {
												echo "
													<br /><br />
													<label for='goodSelect'>Выберите товар:</label>
													<br />
													<select id='goodSelect' name='goodID' onchange='selectGood(\"".$_REQUEST['type']."\", \"".$_REQUEST['category']."\", \"".$_REQUEST['subcategory']."\", \"".$_REQUEST['subcategory2']."\", this.options[this.selectedIndex].value)'>
														<option value=''>- Выберите товар -</option>
												";

												$goodsResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$s2."' ORDER BY name");
												while($goods = $goodsResult->fetch_assoc()) {
													echo "<option value='".$goods['id']."'"; if($id == $goods['id']) {echo " selected";} echo ">".$goods['name']."</option>";
												}

												echo "</select>";

												if(!empty($_REQUEST['id'])) {
													showForm();
												}
											}
											else {
												echo "<br /><br /><b>К сожалению, выбранный раздел не содержит товаров.</b>";
											}
										}
									} else {
										$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory = '".$s."'");
										$goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

										if($goodsCount[0] > 0) {
											echo "
												<br /><br />
												<label for='goodSelect'>Выберите товар:</label>
												<br />
												<select id='goodSelect' name='goodID' onchange='selectGood(\"".$_REQUEST['type']."\", \"".$_REQUEST['category']."\", \"".$_REQUEST['subcategory']."\", \"".$_REQUEST['subcategory2']."\", this.options[this.selectedIndex].value)'>
													<option value=''>- Выберите товар -</option>
											";

											$goodsResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$s."' ORDER BY name");
											while($goods = $goodsResult->fetch_assoc()) {
												echo "<option value='".$goods['id']."'"; if($id == $goods['id']) {echo " selected";} echo ">".$goods['name']."</option>";
											}

											echo "</select>";

											if(!empty($_REQUEST['id'])) {
												showForm();
											}
										} else {
											echo "<br /><br /><b>К сожалению, выбранный раздел не содержит товаров.</b>";
										}
									}
								}
							} else {
								$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE category = '".$c."'");
								$goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

								if($goodsCount[0] > 0) {
									echo "
										<br /><br />
										<label for='goodSelect'>Выберите товар:</label>
										<br />
										<select id='goodSelect' name='goodID' onchange='selectGood(\"".$_REQUEST['type']."\", \"".$_REQUEST['category']."\", \"".$_REQUEST['subcategory']."\", \"".$_REQUEST['subcategory2']."\", this.options[this.selectedIndex].value)'>
											<option value=''>- Выберите товар -</option>
									";

									$goodsResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$c."' ORDER BY name");
									while($goods = $goodsResult->fetch_assoc()) {
										echo "<option value='".$goods['id']."'"; if($id == $goods['id']) {echo " selected";} echo ">".$goods['name']."</option>";
									}

									echo "</select>";

									if(!empty($_REQUEST['id'])) {
										showForm();
									}
								} else {
									echo "<br /><br /><b>К сожалению, выбранный раздел не содержит товаров.</b>";
								}
							}
						}
					}
				?>
			</form>
			<div id="goodsTable" <?php if(empty($_REQUEST['category'])) {echo " style='display: none;'";} ?>>
				<?php
					if(!empty($_REQUEST['category'])) {
						if(!empty($_REQUEST['subcategory2'])) {
							$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory2 = '".$s2."'");
							$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$s2."' ORDER BY name");
						} else {
							if(!empty($_REQUEST['subcategory'])) {
								$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory = '".$s."'");
								$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$s."' ORDER BY name");
							} else {
								$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE category = '".$c."'");
								$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$c."' ORDER BY name");
							}
						}

						$goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

						echo "
							<span>Товары, представленные в выбранном разделе:</span>
							<br />
							<span style='font-size: 14px;'><b>Всего товаров: </b>".$goodsCount[0]."</span>
							<br /><br />
							<table style='text-align: center;'>
								<tr>
									<td style='font-weight: bold; background-color: #ededed;'>№</td>
									<td style='font-weight: bold; background-color: #ededed; width: 100px;'>Фото</td>
									<td style='font-weight: bold; background-color: #ededed;'>Название</td>
									<td style='font-weight: bold; background-color: #ededed;'>Артикул</td>
								</tr>
						";
						$i = 0;

						while($good = $goodResult->fetch_assoc()) {
							$i++;
							$link = "delete.php?type=".$good['type']."&category=".$good['category'];

							if(!empty($good['subcategory']) and $good['subcategory'] != 0) {
								$link .= "&subcategory=".$good['subcategory'];
								if(!empty($good['subcategory2']) and $good['subcategory2'] != 0) {
									$link .= "&subcategory2=".$good['subcategory2'];
								}
							}

							$link .= "&id=".$good['id'];

							echo "
								<tr>
									<td style='background-color: "; if($id == $good['id']) {echo "#cbd7ff";} else {echo "#ededed";} echo ";'>".$i."</td>
									<td style='background-color: #fff; width: 100px;'><a href='../../img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='../../img/catalogue/small/".$good['small']."' /></a></td>
									<td"; if($id == $good['id']) {echo " style='background-color: #cbd7ff;'";} echo "><a href='".$link."'><span class='link'>".$good['name']."</span></a></td>
									<td"; if($id == $good['id']) {echo " style='background-color: #cbd7ff;'";} echo ">".$good['code']."</td>
								</tr>
							";
						}

						echo "
							</table>
						";
					}
				?>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 100%; height: 40px;"></div>
	</div>

	<div style="clear: both;"></div>

	<?php
		function showForm() {
			echo "
				<br />
				<div id='responseField'></div>
				<br />
				<label for='deleteGoodButton'>Для удаления товара нажмите на кнопку <b>\"Удалить\"</b></label>
				<br /><br />
				<input type='button' id='deleteGoodButton' class='button' value='Удалить' onmouseover='buttonChange(\"deleteGoodButton\", 1)' onmouseout='buttonChange(\"deleteGoodButton\", 0)' style='margin: 0;' onclick='deleteGood()'>
			<div style='clear: both;'></div>
		";
		}
	?>

</body>

</html>