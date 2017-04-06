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

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Добавление записи в клиентскую базу</title>

    <link rel='shortcut icon' href='../../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../../css/admin.css'>
	<link rel="stylesheet" type="text/css" href="../../js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="../../js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../../js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="../../js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="../../js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../../js/notify.js"></script>
	<script type="text/javascript" src="../../js/common.js"></script>
	<script type="text/javascript" src="../../js/md5.js"></script>
	<script type="text/javascript" src="../../js/admin/admin.js"></script>
	<script type="text/javascript" src="../../js/admin/clients/add.js"></script>

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
			<div class="menuPointActive">
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
			<a href="../"><img src="../../img/system/exit.png" id="exitIMG" title="Выйти из панели администрирования" onmouseover="changeIcon('exitIMG', 'exitRed.png', 2)" onmouseout="changeIcon('exitIMG', 'exit.png', 2)" /></a>
		</div>
		<br />
		<div id="admContent">
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="../../img/system/admin/icons/client.png" title="Клиентская база" /></div><div id="breadCrumbsTextContainer"><a href="../admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Клиентская база</span></a> > <a href="add.php"><span class="breadCrumbsText">Добавление записей</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Добавление записи в клиентскую базу</h2>
			<a href="database.php"><input type="button" class="button" id="deleteButton" style="margin-left: 0;" value="База данных" onmouseover="buttonChange('deleteButton', 1)" onmouseout="buttonChange('deleteButton', 0)" /></a>
			<a href="add.php"><input type="button" class="buttonActive" id="addButton" value="Добавление" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<form id="addForm" method="post" enctype="multipart/form-data">
				<label for='nameInput'>Имя человека / название организации:</label>
				<br />
				<input type='text' id='nameInput' name='name' />
				<br /><br />
				<label for='emailInput'>Email:</label>
				<br />
				<input type='text' id='emailInput' name='email' />
				<br /><br />
				<label for='districtSelect'>Выберите область / город:</label>
				<br />
				<select id="districtSelect" name="district">
					<option value="">- Выберите область / город -</option>
					<?php
						$districtResult = $mysqli->query("SELECT * FROM locations ORDER BY id");
						while($district = $districtResult->fetch_assoc()) {
							echo "<option value='".$district['id']."'>".$district['name']."</option>";
						}
					?>
				</select>
				<br /><br />
				<label for='phoneInput'>Номер телефона (опционально):</label>
				<br />
				<input type='text' id='phoneInput' name='phone' />
				<br /><br />
				<label for="textInput">Заметки (опционально):</label>
				<br />
				<textarea id="textInput" name="text"></textarea>
				<br /><br />
				<input type='button' class='button' style='margin: 0;' id='addClientButton' onmouseover='buttonChange("addClientButton", 1)' onmouseout='buttonChange("addClientButton", 0)' onclick='addClient()' value='Добавить' />
			</form>
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