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

if(!empty($_REQUEST['id'])) {
	$photoCheckResult = $mysqli->query("SELECT * FROM awards WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$photoCheck = $photoCheckResult->fetch_array(MYSQLI_NUM);

	if($photoCheck[0] == 0) {
		header("Location: edit.php");
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Редактирование наград</title>

    <link rel='shortcut icon' href='../../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../../css/admin.css'>
	<link rel="stylesheet" type="text/css" href="../../js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="../../js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../../js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="../../js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="../../js/notify.js"></script>
	<script type="text/javascript" src="../../js/common.js"></script>
	<script type="text/javascript" src="../../js/md5.js"></script>
	<script type="text/javascript" src="../../js/admin/admin.js"></script>
	<script type="text/javascript" src="../../js/admin/achievements/edit.js"></script>

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
			<div class="menuPoint">
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
			<div class="menuPointActive">
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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="../../img/system/admin/icons/award.png" title="Достижения и награды" /></div><div id="breadCrumbsTextContainer"><a href="../admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Достижения и награды</span></a> > <a href="edit.php"><span class="breadCrumbsText">Редактирование наград</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Редактирование наград</h2>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" style="margin-left: 0;" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="edit.php"><input type="button" class="buttonActive" id="editButton" value="Редактирование" /></a>
			<a href="delete.php"><input type="button" class="button" id="deleteButton" value="Удаление" onmouseover="buttonChange('deleteButton', 1)" onmouseout="buttonChange('deleteButton', 0)" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<form id="editForm" method="post" enctype="multipart/form-data">
				<label for="awardSelect">Выберите награду:</label>
				<br />
				<select id="awardSelect" name="award" onchange="window.location = 'edit.php?id=' + this.options[this.selectedIndex].value">
					<option value="">- Выберите награду -</option>
					<?php
						$awardResult = $mysqli->query("SELECT * FROM awards ORDER BY name");
						while($award = $awardResult->fetch_assoc()) {
							echo "<option value='".$award['id']."'"; if($_REQUEST['id'] == $award['id']) {echo " selected";} echo ">".$award['name']."</option>";
						}
					?>
				</select>
				<?php
					if(!empty($_REQUEST['id'])) {
						$awardResult = $mysqli->query("SELECT * FROM awards WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
						$award = $awardResult->fetch_assoc();

						echo "
							<br /><br />
							<label for='nameInput'>Название награды:</label>
							<br />
							<input type='text' id='nameInput' name='name' value='".$award['name']."' />
							<br /><br />
							<label for='photoInput'>Фотография:</label>
							<br />
							<a href='../../img/photos/awards/big/".$award['photo_big']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$award['name']."'><span class='link' style='font-size: 14px;'>(нажмите для просмотра фотографии)</span></a>
							<br />
							<input type='file' class='file' id='photoInput' name='photo' />
							<br /><br />
							<input type='button' class='button' style='margin: 0;' id='editAwardButton' onmouseover='buttonChange(\"editAwardButton\", 1)' onmouseout='buttonChange(\"editAwardButton\", 0)' onclick='editAward()' value='Редактировать' />
						";
					}
				?>
			</form>
			<div id="goodsTable">
				<?php

					$photosCountResult = $mysqli->query("SELECT COUNT(id) FROM awards");
					$photosCount = $photosCountResult->fetch_array(MYSQLI_NUM);

					$photoResult = $mysqli->query("SELECT * FROM awards ORDER BY name");

					echo "
						<span>Выберите награду:</span>
						<br />
						<span style='font-size: 14px;'><b>Всего наград: </b>".$photosCount[0]."</span>
						<br /><br />
						<table style='text-align: center;'>
							<tr>
								<td style='font-weight: bold; background-color: #ededed;'>№</td>
								<td style='font-weight: bold; background-color: #ededed; width: 100px;'>Фото</td>
								<td style='font-weight: bold; background-color: #ededed;'>Название</td>
							</tr>
					";

					$i = 0;

					while($photo = $photoResult->fetch_assoc()) {
						$i++;
						$link = "edit.php?id=".$photo['id'];

						echo "
							<tr>
								<td style='background-color: "; if($_REQUEST['id'] == $photo['id']) {echo "#cbd7ff";} else {echo "#ededed";} echo ";'>".$i."</td>
								<td style='background-color: #fff; width: 100px;'><a href='../../img/photos/awards/big/".$photo['photo_big']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$photo['name']."'><img src='../../img/photos/awards/small/".$photo['photo_small']."' /></a></td>
								<td"; if($_REQUEST['id'] == $photo['id']) {echo " style='background-color: #cbd7ff;'";} echo "><a href='".$link."'><span class='link'>".$photo['name']."</span></a></td>
							</tr>
						";
					}

					echo "
						</table>
					";
				?>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 100%; height: 40px;"></div>
	</div>

	<div style="clear: both;"></div>

</body>

</html>