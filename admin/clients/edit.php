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

if(empty($_REQUEST['id'])) {
	header("Location: database.php?p=1");
} else {
	$clientCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$clientCheck = $clientCheckResult->fetch_array(MYSQLI_NUM);

	if($clientCheck[0] == 0) {
		header("Location: database.php?p=1");
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Редактирование записи из клиентской базы</title>

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
	<script type="text/javascript" src="/js/notify.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/md5.js"></script>
	<script type="text/javascript" src="/js/admin/admin.js"></script>
	<script type="text/javascript" src="/js/admin/clients/edit.js"></script>

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
			<div class="menuPointActive">
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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/client.png" title="Клиентская база" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Клиентская база</span></a> > <a href="edit.php"><span class="breadCrumbsText">Редактирование</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Редактирование записи из клиентской базы</h2>
			<a href="database.php"><input type="button" class="buttonActive" id="databaseButton" style="margin-left: 0;" value="Клиентская база" /></a>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="inactive.php"><input type="button" class="button" id="inactiveButton" value="Кто отписался?" onmouseover="buttonChange('inactiveButton', 1)" onmouseout="buttonChange('inactiveButton', 0)" /></a>
            <a href="discount.php"><input type="button" class="button" id="discountButton" value="Обновление скидок" onmouseover="buttonChange('discountButton', 1)" onmouseout="buttonChange('discountButton', 0)" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<form id="editForm" method="post">
				<?php
					$clientResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
					$client = $clientResult->fetch_assoc();
				?>
				<label for='nameInput'>Имя человека / название организации:</label>
				<br />
				<input type='text' id='nameInput' name='name' value='<?= $client['name'] ?>' />
				<br /><br />
				<label for='emailInput'>Email:</label>
				<br />
				<input type='text' id='emailInput' name='email' value='<?= $client['email'] ?>' />
				<br /><br />
				<label for='districtSelect'>Выберите область / город:</label>
				<br />
				<select id="districtSelect" name="district">
					<?php
						$districtResult = $mysqli->query("SELECT * FROM locations ORDER BY id");
						while($district = $districtResult->fetch_assoc()) {
							echo "<option value='".$district['id']."'"; if($district['id'] == $client['location']) {echo " selected";} echo ">".$district['name']."</option>";
						}
					?>
				</select>
				<br /><br />
				<label for="groupSelect">Выберите группу:</label>
				<br />
				<select id="groupSelect" name="group">
					<?php
						$groupResult = $mysqli->query("SELECT * FROM filters ORDER BY name");
						while($group = $groupResult->fetch_assoc()) {
							echo "<option value='".$group['id']."'"; if($client['filter'] == $group['id']) {echo " selected";} echo ">".$group['name']."</option>";
						}
					?>
				</select>
				<br /><br />
				<label for='phoneInput'>Номер телефона (опционально):</label>
				<br />
				<input type='text' id='phoneInput' name='phone' value='<?= $client['phone'] ?>' />
				<br /><br />
				<label for="inSendCheckbox">В рассылке?</label>
				<input type="checkbox" class="checkbox" id="inSendCheckbox" name="inSend" <?php if($client['in_send'] == 1) {echo " checked";} ?>>
				<?php
					if($client['in_send'] == 0) {
						$date = (int)substr($client['disactivation_date'], 8, 2)." ";

						switch(substr($client['disactivation_date'], 5, 2)) {
							case "01":
								$date .= "января";
								break;
							case "02":
								$date .= "февраля";
								break;
							case "03":
								$date .= "марта";
								break;
							case "04":
								$date .= "апреля";
								break;
							case "05":
								$date .= "мая";
								break;
							case "06":
								$date .= "июня";
								break;
							case "07":
								$date .= "июля";
								break;
							case "08":
								$date .= "агуста";
								break;
							case "09":
								$date .= "сентября";
								break;
							case "10":
								$date .= "октября";
								break;
							case "11":
								$date .= "ноября";
								break;
							case "12":
								$date .= "декабря";
								break;
							default: break;
						}

						$date .= " ".substr($client['disactivation_date'], 0, 4)." г. в ".substr($client['disactivation_date'], 11);

						echo "
							<br /><br />
							<label for='disactivationInput'>Дата отписки:</label>
							<br />
							<input type='text' id='disactivationInput' style='color: #7e7e7e;' value='".$date."' readonly />
						";
					}
				?>
				<br /><br />
				<label for="textInput">Заметки (опционально):</label>
				<br />
				<textarea id="textInput" name="text"><?= $client['notes'] ?></textarea>
				<br /><br />
				<input type='button' class='button' style='margin: 0;' id='editClientButton' onmouseover='buttonChange("editClientButton", 1)' onmouseout='buttonChange("editClientButton", 0)' onclick='editClient("<?= $mysqli->real_escape_string($_REQUEST['id']) ?>")' value='Редактировать' />
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