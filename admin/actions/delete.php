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
	$actionCheckResult = $mysqli->query("SELECT COUNT(id) FROM actions WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$actionCheck = $actionCheckResult->fetch_array(MYSQLI_NUM);

	if($actionCheck[0] == 0) {
		header("delete.php");
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Удаление акций</title>

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
	<script type="text/javascript" src="/js/admin/actions/delete.js"></script>

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
			<div class="menuPointActive">
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
				<span style="font-size: 14px;">Вы вошли как пользователь <b style="color: #df4e47;"><?php echo $userLogin[0]; ?></b></span>
			</div>
			<a href="/"><img src="/img/system/exit.png" id="exitIMG" title="Выйти из панели администрирования" onmouseover="changeIcon('exitIMG', 'exitRed.png')" onmouseout="changeIcon('exitIMG', 'exit.png')" /></a>
		</div>
		<br />
		<div id="admContent">
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/sale.png" title="Акции" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Акции</span></a> > <a href="delete.php"><span class="breadCrumbsText">Удаление акций</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Удаление акций</h2>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" style="margin-left: 0;" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="edit.php"><input type="button" class="button" id="editButton" value="Редактирование" onmouseover="buttonChange('editButton', 1)" onmouseout="buttonChange('editButton', 0)" /></a>
			<a href="delete.php"><input type="button" class="buttonActive" id="deleteButton" value="Удаление" /></a>
			<div style="clear: both;"></div>
			<p><b>Удалять разрешено только действующие и запланированные акции.</b></p>
			<form id="deleteForm" method="post">
				<label for="actionSelect">Акция:</label>
				<br />
				<select id="actionSelect" name="action" onchange="window.location = 'delete.php?id=' + this.options[this.selectedIndex].value">
					<option value="">- Выберите акцию -</option>
					<?php
						$actionResult = $mysqli->query("SELECT * FROM actions ORDER BY header");
						while($action = $actionResult->fetch_assoc()) {
							if(strtotime(date('d-m-Y')) <= strtotime($action['to_date'])) {
								echo "
									<option value='".$action['id']."'"; if($_REQUEST['id'] == $action['id']) {echo " selected";} echo ">".$action['header']." — ".$action['from_date']." - ".$action['to_date']."</option>
								";
							}
						}
					?>
				</select>
				<?php
					if(isset($_REQUEST['id'])) {
						echo "
							<br /><br />
							<label for='deleteActionButton'>Удалить акцию?</label>
							<br /><br />
							<input type='button' class='button' style='margin: 0;' id='deleteActionButton' onmouseover='buttonChange(\"deleteActionButton\", 1)' onmouseout='buttonChange(\"deleteActionButton\", 0)' onclick='deleteAction()' value='Удалить' />
						";
					}
				?>
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