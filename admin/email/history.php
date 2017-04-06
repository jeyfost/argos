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

    <title>История email-рассылок</title>

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
	<script type="text/javascript" src="../../js/admin/email/history.js"></script>

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
			<div class="menuPoint">
				<div class="menuIMG"><img src="../../img/system/admin/clients.png" /></div>
				<div class="menuText">Клиентская база</div>
			</div>
		</a>
		<div style="clear: both;"></div>
		<div class="line"></div>
		<a href="../email/">
			<div class="menuPointActive">
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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="../../img/system/admin/icons/mail.png" title="Email-рассылки" /></div><div id="breadCrumbsTextContainer"><a href="../admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Email-рассылки</span></a> > <a href="history.php"><span class="breadCrumbsText">История email-рассылок</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>История email-рассылок</h2>
			<a href="send.php"><input type="button" class="button" id="sendButton" value="Отправление" style="margin-left: 0;" onmouseover="buttonChange('sendButton', 1)" onmouseout="buttonChange('sendButton', 0)" /></a>
			<a href="history.php"><input type="button" class="buttonActive" id="historyButton" value="История" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<div id="goodsTable" <?php if(!empty($_REQUEST['id'])) {echo "style='display: none;'";} ?>>
				<?php
					if(empty($_REQUEST['id'])) {
						//Таблица с историей рассылок
						$historyCountResult = $mysqli->query("SELECT COUNT(id) FROM mail_result");
						$historyCount = $historyCountResult->fetch_array(MYSQLI_NUM);

						$historyResult = $mysqli->query("SELECT * FROM mail_result ORDER BY date DESC");

						echo "
							<span>Выберите рассылку:</span>
							<br />
							<span style='font-size: 14px;'><b>Всего рассылок отправлено: </b>".$historyCount[0]."</span>
							<br /><br />
							<table style='text-align: center;'>
								<tr>
									<td style='font-weight: bold; background-color: #ededed;'>№</td>
									<td style='font-weight: bold; background-color: #ededed;'>Дата</td>
									<td style='font-weight: bold; background-color: #ededed;'>Тема</td>
									<td style='font-weight: bold; background-color: #ededed;'>Получатель</td>
									<td style='font-weight: bold; background-color: #ededed;'>Кол-во отправленных писем</td>
									<td style='font-weight: bold; background-color: #ededed;'>Кол-во доставленных писем</td>
									<td style='font-weight: bold; background-color: #ededed;'>Файлы</td>
								</tr>
						";

						$j = 0;

						while($history = $historyResult->fetch_assoc()) {
							$j++;
							$link = "history.php?id=".$history['id'];
							$sendTo = "";

							if(substr($history['send_to'], 0, 8) == "district" and substr($history['send_to'], 10, 1) == ":") {
								//если отправлено по обалсти
								$district = substr($history['send_to'], 9, 1);
								$locationResult = $mysqli->query("SELECT * FROM locations WHERE id = '".$district."'");
								$location = $locationResult->fetch_assoc();

								$sendTo .= "<b>".$location['name']." область</b>. Получатели:<br /><br />";

								$to = substr($history['send_to'], 12);
								$client = explode(";", $to);

								for($i= 0; $i < count($client); $i++) {
									$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
									$c = $cResult->fetch_assoc();

									$sendTo .= $c['name'];

									if($i < count($client) - 1) {
										$sendTo .= "<br /><hr />";
									}
								}
							} elseif(filter_var($history['send_to'], FILTER_VALIDATE_EMAIL)) {
								//если отправлено по одному адресу

								$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE email = '".$history['send_to']."'");
								$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

								if($emailCheck[0] > 0) {
									$clientResult = $mysqli->query("SELECT * FROM clients WHERE email = '".$history['send_to']."'");
									$client = $clientResult->fetch_assoc();

									$sendTo = $client['name'];
								} else {
									$sendTo = $history['send_to'];
								}
							} else {
								$client = explode(';', $history['send_to']);

								for($i= 0; $i < count($client); $i++) {
									$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
									$c = $cResult->fetch_assoc();

									$sendTo .= $c['name'];

									if($i < count($client) - 1) {
										$sendTo .= "<br /><hr />";
									}
								}
							}

							if($history['files_count'] > 0) {
								$files = "";
								$file = explode(';', $history['filenames']);

								for($i = 0; $i < count($file); $i++) {
									$files .= $file[$i];

									if($i < count($file) - 1) {
										$files .= "<br />";
									}
								}
							} else {
								$files = $history['filenames'];
							}

							if($files == '') {
								$files = "Файлов нет";
							}

							$date = (int)substr($history['date'], 8, 2)." ";

							switch(substr($history['date'], 5, 2)) {
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

							$date .= " ".substr($history['date'], 0, 4)." г. в ".substr($history['date'], 11);

							echo "
								<tr>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} else {echo "#ededed";} echo ";'>".$j."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$date."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'><a href='".$link."'><span class='link'>".$history['subject']."</span></a></td>
									<td style='text-align: left; background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$sendTo."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$history['count']."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$history['send']."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$files."</td>
								</tr>
							";
						}

						echo "
							</table>
						";
					}
				?>
			</div>
			<?php
				if(!empty($_REQUEST['id'])) {
					//Детализация письма
					$id = $mysqli->real_escape_string($_REQUEST['id']);

					$historyResult = $mysqli->query("SELECT * FROM mail_result WHERE id = '".$id."'");
					$history = $historyResult->fetch_assoc();

					if(substr($history['send_to'], 0, 8) == "district" and substr($history['send_to'], 10, 1) == ":") {
						//если отправлено по обалсти
						$district = substr($history['send_to'], 9, 1);
						$locationResult = $mysqli->query("SELECT * FROM locations WHERE id = '".$district."'");
						$location = $locationResult->fetch_assoc();

						$to = substr($history['send_to'], 12);
						$client = explode(";", $to);

						for($i= 0; $i < count($client); $i++) {
							$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
							$c = $cResult->fetch_assoc();

							$sendTo .= $c['name'];

							if($i < count($client) - 1) {
								$sendTo .= "; ";
							}
						}
					} elseif(filter_var($history['send_to'], FILTER_VALIDATE_EMAIL)) {
						//если отправлено по одному адресу

						$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE email = '".$history['send_to']."'");
						$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

						if($emailCheck[0] > 0) {
							$clientResult = $mysqli->query("SELECT * FROM clients WHERE email = '".$history['send_to']."'");
							$client = $clientResult->fetch_assoc();

							$sendTo = $client['name'];
						} else {
							$sendTo = $history['send_to'];
						}
					} else {
						$client = explode(';', $history['send_to']);

						for($i= 0; $i < count($client); $i++) {
							$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
							$c = $cResult->fetch_assoc();

							$sendTo .= $c['name'];

							if($i < count($client) - 1) {
								$sendTo .= "; ";
							}
						}
					}

					if($history['files_count'] > 0) {
						$files = "";
						$file = explode(';', $history['filenames']);

						for($i = 0; $i < count($file); $i++) {
							$files .= $file[$i];

							if($i < count($file) - 1) {
								$files .= "; ";
							}
						}
					} else {
						$files = $history['filenames'];
					}

					if($files == '') {
						$files = "Файлов нет";
					}

					$date = (int)substr($history['date'], 8, 2)." ";

					switch(substr($history['date'], 5, 2)) {
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

					$date .= " ".substr($history['date'], 0, 4)." г. в ".substr($history['date'], 11);

					echo "
						<a href='history.php'><span class='redLink' style='font-style: italic; font-size: 14px;'>Вернуться к истории рассылок</span></a>
						<h3>".$history['subject']."</h3>
						<span style='font-style: italic; font-weight: bold;'>Дата отправления: <span style='font-weight: normal;'>".$date."</span></span>
						<br />
						<span style='font-style: italic; font-weight: bold;'>Получатели: <span style='font-weight: normal;'>".$sendTo."</span></span>
						<br /><br />
						<hr />
						".$history['text']."
						<hr />
					";

					if($history['files_count'] > 0) {
						echo "
							<br />
							<span style='font-style: italic; font-weight: bold;'>Количество прикреплённых файлов: <span style='font-weight: normal;'>".$history['files_count']."</span></span>
							<br />
							<span style='font-style: italic; font-weight: bold;'>Файлы: <span style='font-weight: normal;'>".$files."</span></span>
						";
					}

					echo "
						<br /><br />
						<a href='history.php'><span class='redLink' style='font-style: italic; font-size: 14px;'>Вернуться к истории рассылок</span></a>
					";
				}
			?>
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