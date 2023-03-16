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
		header("Location: add.php");
	}
}

if(!empty($_REQUEST['category'])) {
	$cCheckResult = $mysqli->query("SELECT COUNT(id) FROM categories_new WHERE type = '".$t."' AND id = '".$mysqli->real_escape_string($_REQUEST['category'])."'");
	$cCheck = $cCheckResult->fetch_array(MYSQLI_NUM);

	if($cCheck[0] > 0) {
		$c = $mysqli->real_escape_string($_REQUEST['category']);
	} else {
		header("Location: add.php?type=".$t);
	}
}

if(!empty($_REQUEST['subcategory'])) {
	$sCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '" . $c . "' AND id = '" . $mysqli->real_escape_string($_REQUEST['subcategory']) . "'");
	$sCheck = $sCheckResult->fetch_array(MYSQLI_NUM);

	if ($sCheck[0] > 0) {
		$s = $mysqli->real_escape_string($_REQUEST['subcategory']);
	} else {
		header("Location: add.php?type=" . $t . "&category=" . $c);
	}
}

if(!empty($_REQUEST['add'])) {
	if($_REQUEST['add'] != "true") {
		$link = explode("&add=", $_SERVER['REQUEST_URI']);
		header("Location: ".$link[0]);
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Добавление нового раздела</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/admin/admin.js"></script>
	<script type="text/javascript" src="/js/admin/sections/add.js"></script>

	<style>
		#page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
		#page-preloader .spinner {width: 32px; height: 32px; position: absolute; left: 50%; top: 50%; background: url('/img/system/spinner.gif') no-repeat 50% 50%; margin: -16px 0 0 -16px;}
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
			<a href="/"><img src="/img/system/logo.png" /></a>
		</div>
		<div class="line"></div>
		<a href="/admin/goods/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/goods.png" /></div>
				<div class="menuText">Товары</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/sections/">
			<div class="menuPointActive">
				<div class="menuIMG"><img src="/img/system/admin/sections.png" /></div>
				<div class="menuText">Разделы</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/news/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/news.png" /></div>
				<div class="menuText">Новости</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/actions/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/sale.png" /></div>
				<div class="menuText">Акции</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/photo/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/photo.png" /></div>
				<div class="menuText">Фотогалерея</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/albums/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/album.png" /></div>
				<div class="menuText">Альбомы</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/achievements/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/achievement.png" /></div>
				<div class="menuText">Достижения</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/vacancies/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/person.png" /></div>
				<div class="menuText">Вакансии</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/clients/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/clients.png" /></div>
				<div class="menuText">Клиентская база</div>
			</div>
		</a>
		<div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/employees/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/employees.png" /></div>
                <div class="menuText">Сотрудники</div>
            </div>
        </a>
		<div class="line"></div>
		<a href="/admin/email/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/mail.png" /></div>
				<div class="menuText">Email-рассылки</div>
			</div>
		</a>
		<div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/messages/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/messages.png" /></div>
                <div class="menuText">Сообщения</div>
            </div>
        </a>
        <div style="clear: both;"></div>
		<div class="line"></div>
        <a href="/admin/filters/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/filters.png" /></div>
                <div class="menuText">Фильтры</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
		<a href="/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/home.png" /></div>
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
				<span style="font-size: 14px;">Вы вошли как пользователь <b style="color: #ff282b;"><?php echo $userLogin[0]; ?></b></span>
			</div>
			<a href="/"><img src="/img/system/exit.png" id="exitIMG" title="Выйти из панели администрирования" onmouseover="changeIcon('exitIMG', 'exitRed.png')" onmouseout="changeIcon('exitIMG', 'exit.png')" /></a>
		</div>
		<br />
		<div id="admContent">
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/sections.png" title="Разделы" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Товары</span></a> > <a href="add.php"><span class="breadCrumbsText">Добавление новых разделов</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Добавление разделов</h2>
			<a href="add.php"><input type="button" class="buttonActive" id="addButton" value="Добавление" style="margin-left: 0;" /></a>
			<a href="edit.php"><input type="button" class="button" id="editButton" value="Редактирование" onmouseover="buttonChange('editButton', 1)" onmouseout="buttonChange('editButton', 0)" /></a>
			<a href="delete.php"><input type="button" class="button" id="deleteButton" value="Удаление" onmouseover="buttonChange('deleteButton', 1)" onmouseout="buttonChange('deleteButton', 0)" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<form id="addForm" method="post" enctype="multipart/form-data">
				<label for="typeSelect">Выберите тип товаров:</label>
				<br />
				<select id="typeSelect" name="goodType" onchange="window.location = 'add.php?type=' + this.options[this.selectedIndex].value">
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
						echo "<br /><br />";

						if(empty($_REQUEST['category']) and empty($_REQUEST['add'])) {
							echo "
								<a href='".$_SERVER['REQUEST_URI']."&add=true'><span class='redLink'>Добавить раздел</span></a>
								<br /><br />
							";
						}

						if(!empty($_REQUEST['add']) and empty($_REQUEST['category'])) {
							echo "
								<label for='sectionBlackImg'>Выберите чёрную иконку (21х21):</label>
								<br />
								<input type='file' class='file' name='blackImg' id='sectionBlackImg' />
								<br /><br />
								<label for='sectionRedImg'>Выберите красную иконку (21х21):</label>
								<br />
								<input type='file' class='file' name='redImg' id='sectionRedImg' />
								<br /><br />
								<label for='sectionNameInput'>Название раздела:</label>
								<br />
								<input type='text' name='name' id='sectionNameInput' />
								<br />
								<div id='responseField'></div>
								<br />
								<input type='button' class='button' style='margin: 0;' id='addSectionButton' onmouseover='buttonChange(\"addSectionButton\", 1)' onmouseout='buttonChange(\"addSectionButton\", 0)' onclick='addSection()' value='Добавить' />
							";

							$link = explode("&add=", $_SERVER['REQUEST_URI']);

							echo "<br /><br /><br /><br /><a href='".$link[0]."'><span class='redLink'>Вернуться к выбору разделов</span></a>";
						} else {
							echo "
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

								echo "<br /><br />";

								$subcategoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$c."' ORDER BY name");
								$subcategoryCheck = $subcategoryCheckResult->fetch_array(MYSQLI_NUM);

								if(empty($_REQUEST['add'])) {
									if($subcategoryCheck[0] > 0) {
										if(empty($_REQUEST['subcategory'])) {
											echo "
												<a href='".$_SERVER['REQUEST_URI']."&add=true'><span class='redLink'>Добавить подраздел</span></a>
												<br /><br />
											";
										}
									}

									if($subcategoryCheck[0] > 0) {
										echo "
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
											showForm();
										}
									} else {
										showForm();
									}
								} else {
									showForm();
								}
							}
						}
					}
				?>
			</form>
			<div id="goodsTable" <?php if(empty($_REQUEST['type'])) {echo " style='display: none;'";} ?>>
				<?php
					if(!empty($_REQUEST['type'])) {
						if(!empty($_REQUEST['subcategory'])) {
							$sectionsCountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$s."'");
							$sectionResult = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$s."' ORDER BY name");
						} else {
							if(!empty($_REQUEST['category'])) {
								$sectionsCountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$c."'");
								$sectionResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$c."' ORDER BY name");
							} else {
								$sectionsCountResult = $mysqli->query("SELECT COUNT(id) FROM categories_new WHERE type = '".$t."'");
								$sectionResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$t."' ORDER BY name");
							}
						}

						$sectionsCount = $sectionsCountResult->fetch_array(MYSQLI_NUM);

						echo "
							<span>Подразделы, представленные в выбранном разделе:</span>
							<br />
							<span style='font-size: 14px;'><b>Всего подразделов: </b>".$sectionsCount[0]."</span>
							<br /><br />
							<table style='text-align: center;'>
								<tr>
									<td style='font-weight: bold; background-color: #ededed;'>№</td>
						";

						if(!empty($_REQUEST['type']) and empty($_REQUEST['category'])) {
							echo "<td style='font-weight: bold; background-color: #ededed;'>Иконка</td>";
						}

						echo "
									<td style='font-weight: bold; background-color: #ededed;'>Название</td>
								</tr>
						";

						$i = 0;

						while($section = $sectionResult->fetch_assoc()) {
							$i++;
							echo "
								<tr>
									<td style='background-color: #ededed;'>".$i."</td>
							";

							if(!empty($_REQUEST['type']) and empty($_REQUEST['category'])) {
								echo "<td><img src='/img/icons/".$section['picture']."'></td>";
							}

							echo "
									<td>".$section['name']."</td>
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
				<br /><br />
				<label for='sectionNameInput'>Название подраздела:</label>
				<br />
				<input type='text' id='sectionNameInput' name='name' />
				<br />
				<div id='responseField'></div>
				<br />
				<input type='button' class='button' style='margin: 0;' id='addSectionButton' onmouseover='buttonChange(\"addSectionButton\", 1)' onmouseout='buttonChange(\"addSectionButton\", 0)' onclick='addSubsection()' value='Добавить' />
			";

			if(empty($_REQUEST['subcategory'])) {
				$link = explode("&add=", $_SERVER['REQUEST_URI']);
				echo "<br /><br /><br /><br /><a href='".$link[0]."'><span class='redLink'>Вернуться к выбору разделов</span></a>";
			}
		}
	?>

</body>

</html>