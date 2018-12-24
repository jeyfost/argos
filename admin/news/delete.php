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

if(!empty($_REQUEST['type']) and $_REQUEST['type'] != 2 and $_REQUEST['type'] != 1) {
	header("Location: edit.php");
}

if(!empty($_REQUEST['year'])) {
	$type = $mysqli->real_escape_string($_REQUEST['type']);
	$year = $mysqli->real_escape_string($_REQUEST['year']);

	$newsCheckResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE client = '".$type."' AND year = '".$year."'");
	$newsCheck = $newsCheckResult->fetch_array(MYSQLI_NUM);

	if($newsCheck[0] <= 0) {
		header("Location: edit.php?type=".$type);
	}
}

if(!empty($_REQUEST['id'])) {
	$id = $mysqli->real_escape_string($_REQUEST['id']);
	$type = $mysqli->real_escape_string($_REQUEST['type']);
	$year = $mysqli->real_escape_string($_REQUEST['year']);

	$newsCheckResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE client = '".$type."' AND year = '".$year."' AND id = '".$id."'");
	$newsCheck = $newsCheckResult->fetch_array(MYSQLI_NUM);

	if($newsCheck[0] <= 0) {
		header("Location: edit.php?type=".$type."&year=".$year);
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Удаление новостей</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/admin/admin.js"></script>
	<script type="text/javascript" src="/js/admin/news/delete.js"></script>

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
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/sections.png" /></div>
				<div class="menuText">Разделы</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="/admin/news/">
			<div class="menuPointActive">
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
		<a href="/admin/email/">
			<div class="menuPoint">
				<div class="menuIMG"><img src="/img/system/admin/mail.png" /></div>
				<div class="menuText">Email-рассылки</div>
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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/rss.png" title="Новости" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Новости</span></a> > <a href="delete.php"><span class="breadCrumbsText">Удаление новостей</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Удаление новостей</h2>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" style="margin-left: 0;" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="edit.php"><input type="button" class="button" id="editButton" value="Редактирование" onmouseover="buttonChange('editButton', 1)" onmouseout="buttonChange('editButton', 0)" /></a>
			<a href="delete.php"><input type="button" class="buttonActive" id="deleteButton" value="Удаление" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<form id="editForm" method="post" enctype="multipart/form-data">
				<label for="newsTypeSelect">Выберите тип новости:</label>
				<br />
				<select id="newsTypeSelect" name="newsType" onchange="window.location = 'delete.php?type=' + this.options[this.selectedIndex].value">
					<option value="">- Выберите тип новости -</option>
					<option value="2" <?php if($_REQUEST['type'] == 2) {echo " selected";} ?>>Общая</option>
					<option value="1" <?php if($_REQUEST['type'] == 1) {echo " selected";} ?>>Для клиентов</option>
				</select>

				<?php
					if(!empty($_REQUEST['type'])) {
						$type = $mysqli->real_escape_string($_REQUEST['type']);

						$yearResult = $mysqli->query("SELECT DISTINCT(year) FROM news WHERE client = '".$type."' ORDER BY year DESC");
						echo "
							<br /><br />
							<label for='yearSelect'>Выберите год:</label>
							<br />
							<select id='yearSelect' name='year' onchange='selectYear(\"".$type."\", this.options[this.selectedIndex].value)'>
								<option value=''>- Выберите год -</option>
						";

						while($year = $yearResult->fetch_array(MYSQLI_NUM)) {
							echo "<option value='".$year[0]."'"; if($_REQUEST['year'] == $year[0]) {echo " selected";} echo ">".$year[0]."</option>";
						}

						echo "</select>";

						if(!empty($_REQUEST['year'])) {
							$year = $mysqli->real_escape_string($_REQUEST['year']);

							$newsResult = $mysqli->query("SELECT * FROM news WHERE client = '".$type."' AND year = '".$year."' ORDER BY header");

							echo "
								<br /><br />
								<label for='newsSelect'>Выберите новость:</label>
								<br />
								<select id='newsSelect' name='news' onchange='selectNews(\"".$type."\", \"".$year."\", this.options[this.selectedIndex].value)'>
									<option value=''>- Выберите новость -</option>
							";

							while($news = $newsResult->fetch_assoc()) {
								echo "<option value='".$news['id']."'"; if($_REQUEST['id'] == $news['id']) {echo " selected";} echo ">".$news['header']."</option>";
							}

							echo "</select>";

							if(!empty($_REQUEST['id'])) {
								$newsResult = $mysqli->query("SELECT * FROM news WHERE id = '".$id."'");
								$news = $newsResult->fetch_assoc();

								echo "
									<br /><br />
									<label>Удалить новость?</label>
									<br />
									<div id='responseField'></div>
									<br />
									<input type='button' class='button' style='margin: 0;' id='deleteNewsButton' onmouseover='buttonChange(\"deleteNewsButton\", 1)' onmouseout='buttonChange(\"deleteNewsButton\", 0)' onclick='deleteNews()' value='Удалить' />
								";
							}
						}
					}
				?>
			</form>
			<div id="goodsTable" <?php if(empty($_REQUEST['type'])) {echo " style='display: none;'";} ?>>
				<?php
					$id = $mysqli->real_escape_string($_REQUEST['id']);

					if(!empty($_REQUEST['type'])) {
						if(!empty($_REQUEST['year'])) {
							$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE client = '".$type."' AND year = '".$year."'");
							$newsResult = $mysqli->query("SELECT * FROM news WHERE client = '".$type."' AND year = '".$year."' ORDER BY header");
						} else {
							$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE client = '".$type."'");
							$newsResult = $mysqli->query("SELECT * FROM news WHERE client = '".$type."' ORDER BY header");
						}

						$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

						echo "
							<span>Новости, выбранные по указанным параметрам:</span>
							<br />
							<span style='font-size: 14px;'><b>Всего новостей: </b>".$newsCount[0]."</span>
							<br /><br />
							<table style='text-align: center;'>
								<tr>
									<td style='font-weight: bold; background-color: #ededed;'>№</td>
									<td style='font-weight: bold; background-color: #ededed; width: 100px;'>Фото</td>
									<td style='font-weight: bold; background-color: #ededed;'>Заголовок</td>
								</tr>
						";
						$i = 0;

						while($news = $newsResult->fetch_assoc()) {
							$i++;
							$link = "delete.php?type=".$news['client']."&year=".$news['year']."&id=".$news['id'];

							echo "
								<tr>
									<td style='background-color: "; if($id == $news['id']) {echo "#cbd7ff";} else {echo "#ededed";} echo ";'>".$i."</td>
									<td style='background-color: #fff; width: 100px;'><a href='/img/photos/news/".$news['preview']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$news['header']."'><img src='/img/photos/news/".$news['preview']."' style='width: 100px;' /></a></td>
									<td"; if($id == $news['id']) {echo " style='background-color: #cbd7ff;'";} echo "><a href='".$link."'><span class='link'>".$news['header']."</span></a></td>
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

	<script type="text/javascript">
		CKEDITOR.replace("text");
	</script>

</body>

</html>