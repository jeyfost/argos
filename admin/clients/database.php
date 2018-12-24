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

if(empty($_REQUEST['p'])) {
	if(empty($_REQUEST['district'])) {
		header("Location: database.php?p=1");
	} else {
		header("Location: database.php?district=".$_REQUEST['district']."&p=1");
	}
}

if(!empty($_REQUEST['district'])) {
	if($_REQUEST['district'] != "all") {
		$districtCheckResult = $mysqli->query("SELECT COUNT(id) FROM locations WHERE id = '".$mysqli->real_escape_string($_REQUEST['district'])."'");
		$districtCheck = $districtCheckResult->fetch_array(MYSQLI_NUM);

		if($districtCheck[0] == 0) {
			header("Location: database.php?p=1");
		}
	}
}

if(!empty($_REQUEST['district'])) {
	if($_REQUEST['district'] != "all") {
		$clientsCountResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE location = '".$mysqli->real_escape_string($_REQUEST['district'])."'");
		$clientsCount = $clientsCountResult->fetch_array(MYSQLI_NUM);
	} else {
		$clientsCountResult = $mysqli->query("SELECT COUNT(id) FROM clients");
		$clientsCount = $clientsCountResult->fetch_array(MYSQLI_NUM);
	}
} else {
	$clientsCountResult = $mysqli->query("SELECT COUNT(id) FROM clients");
	$clientsCount = $clientsCountResult->fetch_array(MYSQLI_NUM);
}

if($clientsCount[0] > 10) {
	if($clientsCount[0] % 10 == 0) {
		$numbers = intval($clientsCount[0] / 10);
	} else {
		$numbers = intval($clientsCount[0] / 10) + 1;
	}
} else {
	$numbers = 1;
}

if(!empty($_REQUEST['p'])) {
	if($_REQUEST['p'] < 1 or $_REQUEST['p'] > $numbers) {
		$link = "database.php";

		if(!empty($_REQUEST['district'])) {
			$link .= "?district=".$_REQUEST['district'];
		}

		header("Location: ".$link);
	}
}

if(!empty($_REQUEST['p'])) {
	$page = $mysqli->real_escape_string($_REQUEST['p']);
} else {
	$page = 1;
}

$start = intval($page) * 10 - 10;

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Клиентская база</title>

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
	<script type="text/javascript" src="/js/admin/clients/database.js"></script>

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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/client.png" title="Клиентская база" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Клиентская база</span></a> > <a href="database.php"><span class="breadCrumbsText">Работа с базой</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>Клиентская база</h2>
			<a href="database.php"><input type="button" class="buttonActive" id="databaseButton" style="margin-left: 0;" value="База данных" /></a>
			<a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
			<a href="inactive.php"><input type="button" class="button" id="inactiveButton" value="Кто отписался?" onmouseover="buttonChange('inactiveButton', 1)" onmouseout="buttonChange('inactiveButton', 0)" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<div id="searchList" style="padding-right: 18px;"></div>
			<form id="sortForm" method="post" enctype="multipart/form-data">
				<label for='districtSelect'>Клиенты из области:</label>
				<br />
				<select id="districtSelect" name="district" onchange="window.location = 'database.php?district=' + this.options[this.selectedIndex].value">
					<option value="all" selected>Все области</option>
					<?php
						$districtResult = $mysqli->query("SELECT * FROM locations ORDER BY id");
						while($district = $districtResult->fetch_assoc()) {
							echo "<option value='".$district['id']."'"; if($_REQUEST['district'] == $district['id']) {echo " selected";} echo ">".$district['name']."</option>";
						}
					?>
				</select>
				<br /><br />
				<label for="searchInput">Поиск клиента:</label>
				<br />
				<input type="text" id="searchInput" placeholder="Любые данные по клиенту..." onkeyup="searchClient()" onblur="searchBlur()" />
				<br /><br />
				<table>
					<thead style="background-color: #ececec;">
						<td>№</td>
						<td>Имя/организация</td>
						<td>Телефон</td>
						<td>Email</td>
						<td>Область/город</td>
						<td>Группа</td>
						<td>В рассылке</td>
						<td>Заметки</td>
						<td>Редактирование</td>
					</thead>
					<tbody id="clientsTable">
						<?php
							if(!empty($_REQUEST['district'])) {
								if($_REQUEST['district'] == "all") {
									$clientResult = $mysqli->query("SELECT * FROM clients ORDER BY name LIMIT ".$start.", 10");
								} else {
									$district = $mysqli->real_escape_string($_REQUEST['district']);
									$clientResult = $mysqli->query("SELECT * FROM clients WHERE location = '".$district."' ORDER BY name LIMIT ".$start.", 10");
								}
							} else {
								$clientResult = $mysqli->query("SELECT * FROM clients ORDER BY name LIMIT ".$start.", 10");
							}

							if(!empty($_REQUEST['p'])) {
								$i = $page * 10 - 10;
							} else {
								$i = 0;
							}

							while($client = $clientResult->fetch_assoc()) {
								$i++;
								$locationResult = $mysqli->query("SELECT name FROM locations WHERE id = '".$client['location']."'");
								$location = $locationResult->fetch_array(MYSQLI_NUM);

								$groupResult = $mysqli->query("SELECT name FROM filters WHERE id = '".$client['filter']."'");
								$group = $groupResult->fetch_array(MYSQLI_NUM);

								if($client['in_send'] == "1") {
									$inSend = "да";
								} else {
									$inSend = "нет";
								}

								echo "
									<tr id='tr".$i."'"; if($i % 2 == 0) {echo " style='background-color: #ededed;'";} echo " onmouseover='searchItemHover(\"tr".$i."\", 1, \"".$i."\")' onmouseout='searchItemHover(\"tr".$i."\", 0, \"".$i."\")'>
										<td>".$i."</td>
										<td>".$client['name']."</td>
										<td>".$client['phone']."</td>
										<td>".$client['email']."</td>
										<td style='text-align: center;'>".$location[0]."</td>
										<td style='text-align: center;'>".$group[0]."</td>
										<td style='text-align: center;'>".$inSend."</td>
										<td>".$client['notes-']."</td>
										<td style='text-align: center;'><a href='edit.php?id=".$client['id']."'><span class='redLink' style='font-size: 14px;'>Редактировать</span></a></td>
									</tr>
								";
							}
 						?>
					</tbody>
				</table>
			</form>
			<br />
			<div style="clear: both;"></div>
			<?php
				echo "<div id='pageNumbers'>";

				if($numbers > 1) {
					$uri = explode("&p=", $_SERVER['REQUEST_URI']);
					$link = $uri[0]."&p=";
					if($numbers <= 7) {
						echo "<br /><br />";

						if($_REQUEST['p'] == 1) {
							echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
						} else {
							echo "<a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>";
						}

						for($i = 1; $i <= $numbers; $i++) {
							if($_REQUEST['p'] != $i) {
								echo "<a href='".$link.$i."'>";
							}

							echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

							if($_REQUEST['p'] != $i) {
								echo "</a>";
							}
						}

						if($_REQUEST['p'] == $numbers) {
							echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
						} else {
							echo "<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
						}

						echo "</div>";

					} else {
						if($_REQUEST['p'] < 5) {
							if($_REQUEST['p'] == 1) {
								echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
							} else {
								echo "<a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>";
							}

							for($i = 1; $i <= 5; $i++) {
								if($_REQUEST['p'] != $i) {
									echo "<a href='".$link.$i."'>";
								}

								echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

								if($_REQUEST['p'] != $i) {
									echo "</a>";
								}
							}

							echo "<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
							echo "<a href='".$link.$numbers."'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>";

							if($_REQUEST['p'] == $numbers) {
								echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
							} else {
								echo "<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
							}

							echo "</div>";
						} else {
							$check = $numbers - 3;

							if($_REQUEST['p'] >= 5 and $_REQUEST['p'] < $check) {
								echo "
									<br /><br />
									<div id='pageNumbers'>
										<a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>
										<a href='".$link."1'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='goodStyleRed' id='pbt1'>1</span></div></a>
										<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
										<a href='".$link.($_REQUEST['p'] - 1)."'><div id='pb".($_REQUEST['p'] - 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($_REQUEST['p'] - 1)."\", \"pbt".($_REQUEST['p'] - 1)."\")' onmouseout='pageBlock(0, \"pb".($_REQUEST['p'] - 1)."\", \"pbt".($_REQUEST['p'] - 1)."\")'><span class='goodStyleRed' id='pbt".($_REQUEST['p'] - 1)."'>".($_REQUEST['p'] - 1)."</span></div></a>
										<div class='pageNumberBlockActive'><span class='goodStyleWhite'>".$_REQUEST['p']."</span></div>
										<a href='".$link.($_REQUEST['p'] + 1)."'><div id='pb".($_REQUEST['p'] + 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($_REQUEST['p'] + 1)."\", \"pbt".($_REQUEST['p'] + 1)."\")' onmouseout='pageBlock(0, \"pb".($_REQUEST['p'] + 1)."\", \"pbt".($_REQUEST['p'] + 1)."\")'><span class='goodStyleRed' id='pbt".($_REQUEST['p'] + 1)."'>".($_REQUEST['p'] + 1)."</span></div></a>
										<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
										<a href='".$link.$numbers."'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>
										<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>
									</div>
								";
							} else {
								echo "
									<br /><br />
									<div id='pageNumbers'>
										<a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>
										<a href='".$link."1'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='goodStyleRed' id='pbt1'>1</span></div></a>
										<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
								";

								for($i = ($numbers - 4); $i <= $numbers; $i++) {
									if($_REQUEST['p'] != $i) {
										echo "<a href='".$link.$i."'>";
									}

									echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

									if($_REQUEST['p'] != $i) {
										echo "</a>";
									}
								}

								if($_REQUEST['p'] == $numbers) {
									echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
								} else {
									echo "<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
								}
							}
						}
					}
				}

				echo "<div style='clear: both;'></div>";
			?>
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