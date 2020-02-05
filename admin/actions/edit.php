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
		header("edit.php");
	}
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Редактирование акций</title>

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
	<script type="text/javascript" src="/js/admin/actions/add.js"></script>
	<script type="text/javascript" src="/js/admin/actions/edit.js"></script>

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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/sale.png" title="Акции" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Акции</span></a> > <a href="edit.php"><span class="breadCrumbsText">Редактирование акций</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Редактирование акций</h2>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" style="margin-left: 0;" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="edit.php"><input type="button" class="buttonActive" id="editButton" value="Редактирование" /></a>
			<a href="delete.php"><input type="button" class="button" id="deleteButton" value="Удаление" onmouseover="buttonChange('deleteButton', 1)" onmouseout="buttonChange('deleteButton', 0)" /></a>
			<div style="clear: both;"></div>
			<p><b>Редактировать разрешено только действующие и запланированные акции.</b></p>
			<br /><br />
			<form id="editForm" method="post" enctype="multipart/form-data">
				<label for="actionSelect">Акция:</label>
				<br />
				<select id="actionSelect" name="action" onchange="window.location = 'edit.php?id=' + this.options[this.selectedIndex].value">
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
						$actionID = $mysqli->real_escape_string($_REQUEST['id']);
						$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID."'");
						$action = $actionResult->fetch_assoc();

						echo "
							<br /><br />
							<label for='headerInput'>Заголовок акции:</label>
							<br />
							<input type='text' id='headerInput' name='header' value='".$action['header']."' />
							<br /><br />
							<label for='previewInput'>Превью акции (минимум 200x130 пикселей):</label>
							<br />
							<input type='file' class='file' id='previewInput' name='previewPhoto' />
							<br />
							<a href='/img/photos/actions/".$action['preview']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='redLink'>нажмите для простора текущей превью</span></a>
							<br /><br />
							<label>Срок проведения акции (дни указываются включительно в формате <b>дд-мм-гггг</b>):</label>
							<br /><br />
							<div>
								<div class='dateInput'>
									<label for='fromInput'>Дата начала:</label>
									<br />
									<input type='text' id='fromInput' name='from' class='smallInput' value='".$action['from_date']."' />
								</div>
								<div class='dateInput' style='margin-left: 40px;'>
									<label for='toInput'>Дата окончания:</label>
									<br />
									<input type='text' id='toInput' name='to' class='smallInput' value='".$action['to_date']."' />
								</div>
								<div style='clear: both;'></div>
							</div>
							<br /><br />
							<label for='textInput'>Описание акции:</label>
							<br />
							<textarea id='textInput' name='text'>".$action['text']."</textarea>
							<br /><br />
							<hr>
							<h2 style='margin-top: 23px;'>Акционные товары</h2>
							<hr>
							<br />
							<div id='searchList'></div>
							<div id='goodsBlock'>
						";

						$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE action_id = '".$action['id']."'");
						if($actionGoodResult->num_rows > 0) {
							while($actionGood = $actionGoodResult->fetch_assoc()) {
								$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$actionGood['good_id']."'");
								$good = $goodResult->fetch_assoc();
								$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
								$unit = $unitResult->fetch_assoc();
								$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
								$currency = $currencyResult->fetch_assoc();
								$randomID = md5(rand(0, 1000000).md5(date('d-mY H-i-s')));

								echo "
									<div class='actionGoodBlock' id='".$randomID."' style='background-color: #f8f8f8;'>
										<div style='float: right;'>
											<img src='/img/system/delete.png' style='cursor: pointer;' id='di".$randomID."' onmouseover='changeDeleteIcon(\"di".$randomID."\", 1)' onmouseout='changeDeleteIcon(\"di".$randomID."\", 0)' title='Убрать этот блок' onclick='closeGoodBlock(\"".$randomID."\")' />
										</div>
										<div style='clear: both;'></div>
										<br />
										<input type='text' id='search_".$randomID."' class='searchFieldInput' value='Поиск...' onfocus='searchFocus(\"search_".$randomID."\")' onblur='searchBlur(\"search_".$randomID."\")' onkeyup='searchGood(\"search_".$randomID."\")' />
										<br />
										<div id='g_".$randomID."' class='goodBlock' good_id='".$good['id']."'>
								";

								$price = $good['price'] * $currency['rate'];
								$roubles = floor($price);
								$kopeck = ceil(($price - $roubles) * 100);

								if($kopeck == 100) {
									$kopeck = 0;
									$roubles ++;
								}

								if($roubles == 0 and $kopeck == 0) {
									$kopeck = 1;
								}

								$today = strtotime(date('d-m-Y'));
								$actionCount = 0;
								$status = "<br /><br />Товар принимает участие в следущих акциях: ";

								$goodActionResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$good['id']."'");
								while($goodAction = $goodActionResult->fetch_assoc()) {
									$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$goodAction['action_id']."'");

									while($action = $actionResult->fetch_assoc())
									{
										if(strtotime($action['from_date']) >= $today or (strtotime($action['from_date']) < $today and strtotime($action['to_date']) >= $today)) {
											$actionCount++;
											$status .= "c <span style='color: #ff282b;'>".$action['from_date']."</span> по <span style='color: #ff282b;'>".$action['to_date']."</span>; ";
										}
									}
								}

								if($actionCount > 0) {
									$status = substr($status, 0 , strlen($status) - 2).".";
								} else {
									$status = "";
								}

								echo "
									<br />
									<div class='goodImg'>
										<a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
									</div>
									<div class='goodInfo'>
										<div class='goodName'>
											<div style='width: 5px; height: 30px; background-color: #ff282b; position: relative; float: left;'></div>
											<div style='margin-left: 15px;'>".$good['name']."</div>
											<div style='clear: both;'></div>
										</div>
										<div class='goodDescription'>
								";
								$description = str_replace("\n", "<br />", $good['description']);
								$strings = explode("<br />", $description);
								for($i = 0; $i < count($strings); $i++) {
									$string = explode(':', $strings[$i]);
									if(count($string) > 1) {
										for($j = 0; $j < count($string); $j++) {
											if($j == 0) {
												echo "<b>".$string[$j].":</b>";
											} else {
												if($j == (count($string) - 1)) {
													echo $string[$j];
												} else {
													echo $string[$j].":";
												}
											}
										}
										echo "<br />";
									} else {
										echo $string[0]."<br />";
									}
								}
								echo "
											<br />
											<b>Артикул: </b>".$good['code']."
											<br />
											<span><b>Стоимость за ".$unit['for_name'].": </b>"; if($roubles > 0) {echo $roubles." руб. ";} echo ceil($kopeck)." коп.</span>
											".$status."
											<br /><br >
											<label for='np_".$randomID."'>Акционная стоимость в <b>".$currency['code']." (".$currency['currency_name'].")</b>:</label>
											<br />
											<input type='number' min='0.0001' step='0.0001' class='actionGoodPrice' id='np_".$randomID."' value='".$actionGood['price']."' />
								";

								if($good['sketch'] != '') {
									echo "<br /><br /><a href='/img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
								}

								echo "
										</div>
										<div style='clear: both;'></div>
								";

								echo "
										</div>
										<div style='clear: both;'></div>
									</div>
									</div>
								";
							}
						}

						echo "
							</div>
							<br />
							<span class='redLink' style='text-decoration: none; border-bottom: 1px dashed #ff282b;' onclick='addGoodBlock()'>+ Добавить ещё один товар</span>
							<br /><br />
							<input type='button' class='button' style='margin: 0;' id='editActionButton' onmouseover='buttonChange(\"editActionButton\", 1)' onmouseout='buttonChange(\"editActionButton\", 0)' onclick='editAction()' value='Редактировать' />
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