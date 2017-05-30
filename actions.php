<?php

session_start();

include ("scripts/connect.php");
include ("scripts/actions.php");

if(!empty($_REQUEST['year'])) {
	$actionsCountResult = $mysqli->query("SELECT COUNT(id) FROM actions WHERE year = '".$mysqli->real_escape_string($_REQUEST['year'])."'");
	$actionsCount = $actionsCountResult->fetch_array(MYSQLI_NUM);

	if($actionsCount[0] == 0) {
		header("Location: actions.php");
	}
}

if(!empty($_REQUEST['id'])) {
	$actionsCountResult = $mysqli->query("SELECT COUNT(id) FROM actions WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$actionsCount = $actionsCountResult->fetch_array(MYSQLI_NUM);

	if($actionsCount[0] == 0) {
		header("Location: actions.php");
	}
}

if(isset($_SESSION['userID'])) {
	if(isset($_COOKIE['argosfm_login']) and isset($_COOKIE['argosfm_password'])) {
		setcookie("argosfm_login", "", 0, '/');
		setcookie("argosfm_password", "", 0, '/');
		setcookie("argosfm_login", $_COOKIE['argosfm_login'], time()+60*60*24*30*12, '/');
		setcookie("argosfm_password", $_COOKIE['argosfm_password'], time()+60*60*24*30*12, '/');
	}
	else {
		$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
		$user = $userResult->fetch_assoc();
		setcookie("argosfm_login", $user['login'], time()+60*60*24*30*12, '/');
		setcookie("argosfm_password", $user['password'], time()+60*60*24*30*12, '/');
	}
} else {
	if(isset($_COOKIE['argosfm_login']) and isset($_COOKIE['argosfm_password']) and !empty($_COOKIE['argosfm_login']) and !empty($_COOKIE['argosfm_password'])) {
		$userResult = $mysqli->query("SELECT * FROM users WHERE login = '".$_COOKIE['argosfm_login']."'");
		$user = $userResult->fetch_assoc();

		if(!empty($user) and $user['password'] == $_COOKIE['argosfm_password']) {
			$_SESSION['userID'] = $user['id'];
		} else {
			setcookie("argosfm_login", "", 0, '/');
			setcookie("argosfm_password", "", 0, '/');
		}
	}
}

if(isset($_SESSION['userID'])) {
	$loginsCountResult = $mysqli->query("SELECT logins_count FROM users WHERE id = '".$_SESSION['userID']."'");
	$loginsCount = $loginsCountResult->fetch_array(MYSQLI_NUM);
	$count = $loginsCount[0] + 1;

	$mysqli->query("UPDATE users SET last_login = '".date('d-m-Y H:i:s')."', logins_count = '".$count."' WHERE id = '".$_SESSION['userID']."'");
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">
    <meta name='keywords' content='мебельная фурнитура, комплектующие для мебели, Аргос-ФМ, комплектующие для мебели Могилев, Могилев, кромочные материалы, кромка, кромка ПВХ, ручки мебельные, мебельная фурнитура Могилев, кромка ПВХ Могилев, лента кромочная, лента кромочная Могилев, ручки мебельные Могилев, кромка Могилев'>
    <meta name='description' content='Комплексные поставки всех видов мебельной фурнитуры импортного и отечественного производства. Республика Беларусь, г. Могилёв.'>

    <title>Акции</title>

    <link rel='shortcut icon' href='img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='css/style.css'>
	<link rel="stylesheet" type="text/css" href="js/lightview/css/lightview/lightview.css" />
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='css/styleOpera.css'>";
		}
	?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/actions.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="js/lightview/js/lightview/lightview.js"></script>
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<script type='text/javascript' src='js/indexOpera.js'></script>";
		}
	?>

	<style>
		#page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
		#page-preloader .spinner {width: 32px; height: 32px; position: absolute; left: 50%; top: 50%; background: url('img/system/spinner.gif') no-repeat 50% 50%; margin: -16px 0 0 -16px;}
	</style>

    <script type="text/javascript">
        $(window).on('load', function () {
            var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
            $spinner.delay(500).fadeOut();
            $preloader.delay(850).fadeOut('slow');
        });
    </script>

</head>

<body id="bodyIndex">

    <div id="page-preloader"><span class="spinner"></span></div>

    <div id="menu">
        <div class="container" style="height: 100%;">
            <a href="index.php"><img src="img/system/logo.png" id="logo" /></a>
			<div id="personalButtons">
				<?php
					if(isset($_SESSION['userID'])) {
						echo "
							<div class='headerIcon'>
								<a href='scripts/personal/logout.php'><img src='img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exitRed.png\", 0)' onmouseout='changeIcon(\"exitIMG\", \"exit.png\", 0)' /></a>
							</div>
							<div class='headerIcon'>
								<a href='personal/personal.php?section=1'><img src='img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon(\"personalIMG\", \"personalRed.png\", 0)' onmouseout='changeIcon(\"personalIMG\", \"personal.png\", 0)' /></a>
							</div>
						";
						if($_SESSION['userID'] == 1) {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='personal/orders.php?section=1&p=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)'><img src='img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon'>
										<a href='personal/orders.php'><img src='img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)' /></a>
									</div>
								";
							}
						} else {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)'><img src='img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='personal/basket.php'><img src='img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)' /></a>
									</div>
								";
							}
						}
					} else {
						echo "
							<div class='headerIcon'>
								<a href='personal/login.php'><img src='img/system/login.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"loginRed.png\", 0)' onmouseout='changeIcon(\"loginIMG\", \"login.png\", 0)' /></a>
							</div>
						";
					}
					echo "
						<div id='searchBlock'>
							<form method='post'>
								<input type='text' id='searchFieldInput' name=searchField' value='Поиск...' />
							</form>
						</div>
					";
					echo "<div style='clear: both;'></div>";
				?>
			</div>
            <div id="menuLinks">
                <div class="menuLink" id="catalogueLink" onmouseover="showDropdownList('1', 'catalogueLink')">
                    <a href="catalogue.php?type=fa&p=1" class="menuPoint">Каталог</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
                    <a href="about/info.php">О компании</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="news.php">Новости</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
                    <a href="stores/company.php">Где купить</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="actions.php" style="color: #df4e47;">Акции</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink')">
                    <a href="partners/cooperation.php">Партнерам</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="contactsLink" onmouseover="showDropdownList('1', 'contactsLink')">
                    <a href="contacts/stores.php">Контакты</a>
                    <img src="img/system/downArrow.png" />
                </div>
                <div style="clear: both;"></div>
            </div>
        	<div style="clear: both;"></div>
        </div>
       <div id="menuIcon" onclick="showHideMobileMenu()"><img src="img/system/mobile/menuIcon.png" title="Меню" /></div>
		<div id="mobileMenu">
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="catalogue.php?type=fa&p=1" class="mobileMenuPointBig">Каталог</a>
				<div class="subMenu">
					<a href="catalogue.php?type=fa&p=1" class="mobileMenuPointSmall">- Мебельная фурнитура</a>
					<br />
					<a href="catalogue.php?type=em&p=1" class="mobileMenuPointSmall">- Кромочные материалы</a>
					<br />
					<a href="catalogue.php?type=ca&p=1" class="mobileMenuPointSmall">- Аксессуары для штор</a>
					<br />
					<a href="catalogue.php?type=dg&p=1" class="mobileMenuPointSmall">- Сопутствующие товары</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="about/info.php" class="mobileMenuPointBig">О компании</a>
				<div class="subMenu">
					<a href="about/info.php" class="mobileMenuPointSmall">- Общая информация</a>
					<br />
					<a href="about/assortment.php" class="mobileMenuPointSmall">- Ассортимент</a>
					<br />
					<a href="about/awards.php" class="mobileMenuPointSmall">- Достижения и награды</a>
					<br />
					<a href="about/gallery.php" class="mobileMenuPointSmall">- Фотогалерея</a>
					<br />
					<a href="about/vacancies.php" class="mobileMenuPointSmall">- Вакансии</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="news.php" class="mobileMenuPointBig">Новости</a>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="stores/company.php" class="mobileMenuPointBig">Где купить</a>
				<div class="subMenu">
					<a href="stores/company.php" class="mobileMenuPointSmall">- Фирменная сеть</a>
					<br />
					<a href="stores/representatives.php" class="mobileMenuPointSmall">- Партнёрская сеть</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="actions.php" class="mobileMenuPointBig">Акции</a>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="partners/cooperation.php" class="mobileMenuPointBig">Партнёрам</a>
				<div class="subMenu">
					<a href="partners/cooperation.php" class="mobileMenuPointSmall">- Сотрудничество</a>
					<br />
					<a href="partners/news.php" class="mobileMenuPointSmall">- Новости для клиентов</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="contacts/stores.php" class="mobileMenuPointBig">Контакты</a>
				<div class="subMenu">
					<a href="contacts/stores.php" class="mobileMenuPointSmall">- Магазины</a>
					<br />
					<a href="contacts/main.php" class="mobileMenuPointSmall">- Головное предприятие</a>
					<br />
					<a href="contacts/mail.php" class="mobileMenuPointSmall">- Обратная связь</a>
				</div>
			</div>
			<?php
				if(!empty($_SESSION['userID'])) {
					if($_SESSION['userID'] == 1) {
						echo "
							<hr />
							<div class='mobileMenuItem' style='margin-top: 0;'>
								<a href='/personal/orders.php?section=1&p=1' class='mobileMenuPointBig'>Заказы</a>
							</div>
						";
					} else {
						echo "
							<hr />
							<div class='mobileMenuItem' style='margin-top: 0;'>
								<a href='/personal/basket.php?section=1' class='mobileMenuPointBig'>Корзина</a>
							</div>
						";
					}
				}

				if(!empty($_SESSION['userID'])) {
					if($_SESSION['userID'] == 1) {
						echo "
							<hr />
							<div class='mobileMenuItem' style='margin-top: 0;'>
								<a href='/personal/personal.php?section=1' class='mobileMenuPointBig'>Управление сайтом</a>
							</div>
						";
					} else {
						echo "
							<hr />
							<div class='mobileMenuItem' style='margin-top: 0;'>
								<a href='/personal/personal.php?section=1' class='mobileMenuPointBig'>Личный кабинет</a>
							</div>
						";
					}

					echo "
						<hr />
						<div class='mobileMenuItem' style='margin-top: 0;'>
							<a href='/scripts/personal/logout.php' class='mobileMenuPointBig'>Выйти из аккаунта</a>
						</div>
					";
				}
			?>
		</div>
        <div style="clear: both;"></div>

    </div>
    <div id="dropDownLine">
        <div id="dropDownArrowContainer">
            <img src="img/system/dropDownListArrow.png" id="dropDownArrow" />
        </div>
        <div id="dropDownList"></div>
    </div>
    <div id="menuShadow"></div>

	<div id="page">
		<div id="searchList"></div>
		<h1 style='margin-top: 80px;'>Акции</h1>
		<div id='breadCrumbs'>
			<a href='index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='actions.php'><span class='breadCrumbsText'>Акции</span></a>
		</div>

		<div style="width: 100%; text-align: right;">
			<span style='color: #4c4c4c; font-style: italic; font-size: 16px;'>Архив: </span>
			<?php
				$yearResult = $mysqli->query("SELECT DISTINCT year FROM actions ORDER BY year DESC");
				while($year = $yearResult->fetch_array(MYSQLI_NUM)) {
					echo "<a href='actions.php?year=".$year[0]."'><span"; if($_REQUEST['year'] == $year[0]) {echo " style='color: #df4e47; font-style: italic; font-size: 14px;";} else {echo " style='color: #4c4c4c; font-style: italic; font-size: 14px; text-decoration: underline;'";} echo " class='yearFont' id='yf".$year[0]."' onmouseover='fontChange(\"yf".$year[0]."\", 1)' onmouseout='fontChange(\"yf".$year[0]."\", 0)'>".$year[0]."</span></a> ";
				}
			?>
		</div>
		<div style="width: 100%; height: 1px; background-color: #c9c9c9; margin-top: 5px;"></div>
		<br />
		<?php
			if(empty($_REQUEST['id'])) {
				if(empty($_REQUEST['year']) or $_REQUEST['year'] == date("Y")) {
					$actionsResult = $mysqli->query("SELECT * FROM actions ORDER BY id DESC");

					echo "<h2>Действующие акции</h2>";
					$count = 0;

					while($actions = $actionsResult->fetch_assoc()) {
						$dx = (int)date('d');
						$mx = (int)date('m');
						$yx = (int)date('Y');

						$d1 = (int)substr($actions['from_date'], 0, 2);
						$m1 = (int)substr($actions['from_date'], 3, 2);
						$y1 = (int)substr($actions['from_date'], 6, 4);

						$d2 = (int)substr($actions['to_date'], 0, 2);
						$m2 = (int)substr($actions['to_date'], 3, 2);
						$y2 = (int)substr($actions['to_date'], 6, 4);

						if($y1 < $yx and $yx < $y2) {
							echoAction($actions);
							$count++;
						}

						if($y1 < $yx and $yx == $y2) {
							if($mx < $m2) {
								echoAction($actions);
								$count++;
							}

							if($mx == $m2 and $dx <= $d2) {
								echoAction($actions);
								$count++;
							}
						}

						if($y1 == $yx) {
							if($m1 < $mx) {
								if($yx < $y2) {
									echoAction($actions);
									$count++;
								}

								if($yx == $y2) {
									if($mx < $m2) {
										echoAction($actions);
										$count++;
									}

									if($mx == $m2 and $dx <= $d2) {
										echoAction($actions);
										$count++;
									}
								}
							}

							if($m1 == $mx and $d1 <= $dx) {
								if($yx < $y2) {
									echoAction($actions);
									$count++;
								}

								if($yx == $y2) {
									if($mx < $m2) {
										echoAction($actions);
										$count++;
									}

									if($mx == $m2 and $dx <= $d2) {
										echoAction($actions);
										$count++;
									}
								}
							}
						}
					}

					if($count == 0) {
						echo "<p>На данный момент действующих акций нет.</p>";
					}

					echo "
						<br /><br />
						<div style='width: 100%; height: 1px; background-color: #c9c9c9; margin-top: 5px;'></div>
						<br /><br />
						<h2>Запланированные акции</h2>
					";

					$count = 0;
					$actionsResult = $mysqli->query("SELECT * FROM actions ORDER BY id DESC");
					while($actions = $actionsResult->fetch_assoc()) {
						$dx = (int)date('d');
						$mx = (int)date('m');
						$yx = (int)date('Y');

						$d1 = (int)substr($actions['from_date'], 0, 2);
						$m1 = (int)substr($actions['from_date'], 3, 2);
						$y1 = (int)substr($actions['from_date'], 6, 4);

						$d2 = (int)substr($actions['to_date'], 0, 2);
						$m2 = (int)substr($actions['to_date'], 3, 2);
						$y2 = (int)substr($actions['to_date'], 6, 4);

						if($y1 > $yx) {
							echoAction($actions);
							$count++;
						}

						if($y1 == $yx) {
							if($m1 > $mx) {
								echoAction($actions);
								$count++;
							}

							if($m1 == $mx and $d1 > $dx) {
								echoAction($actions);
								$count++;
							}
						}
					}

					if($count == 0) {
						echo "<p>На данный момент запланированных акций нет.</p>";
					}

					echo "
						<br /><br />
						<div style='width: 100%; height: 1px; background-color: #c9c9c9; margin-top: 5px;'></div>
						<br /><br />
						<h2>Завершённые акции</h2>
					";

					$count = 0;
					$actionsResult = $mysqli->query("SELECT * FROM actions ORDER BY id DESC");
					while($actions = $actionsResult->fetch_assoc()) {
						$dx = (int)date('d');
						$mx = (int)date('m');
						$yx = (int)date('Y');

						$d1 = (int)substr($actions['from_date'], 0, 2);
						$m1 = (int)substr($actions['from_date'], 3, 2);
						$y1 = (int)substr($actions['from_date'], 6, 4);

						$d2 = (int)substr($actions['to_date'], 0, 2);
						$m2 = (int)substr($actions['to_date'], 3, 2);
						$y2 = (int)substr($actions['to_date'], 6, 4);

						if($yx > $y2) {
							echoAction($actions);
							$count++;
						}

						if($yx == $y2) {
							if($mx > $m2) {
								echoAction($actions);
								$count++;
							}

							if($mx == $m2 and $dx > $d2) {
								echoAction($actions);
								$count++;
							}
						}
					}

					if($count == 0) {
						echo "<p>Завершённых акций ещё нет.</p>";
					}
				} else {
					echo "<h2>Завершённые акции</h2>";

					$count = 0;
					$actionsResult = $mysqli->query("SELECT * FROM actions WHERE year = '".$_REQUEST['year']."' ORDER BY id DESC");
					while($actions = $actionsResult->fetch_assoc())	{
						echoAction($actions);
						$count++;
					}

					if($count == 0) {
						echo "<p>Акций в ".$_REQUEST['year']."-м году не было.</p>";
					}
				}
			} else {
				$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
				$action = $actionResult->fetch_assoc();

				$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
				$j = 0;
				$type = "";

				if($action['from_date'] != $actions['to_date']) {
					$index1 = (int)substr($action['from_date'], 3, 2) - 1;
					$index2 = (int)substr($action['to_date'], 3, 2) - 1;
					$from_date = substr($action['from_date'], 0, 2)." ".$month[$index1]." ".substr($action['from_date'], 6, 4);
					$to_date = substr($action['to_date'], 0, 2)." ".$month[$index2]." ".substr($action['to_date'], 6, 4);
					$date = $from_date." — ".$to_date;
				} else {
					$index = (int)substr($action['from_date'], 3, 2) - 1;
					$date = substr($action['from_date'], 0, 2)." ".$month[$index]." ".substr($action['from_date'], 6, 4);
				}

				$dx = (int)date('d');
				$mx = (int)date('m');
				$yx = (int)date('Y');

				$d1 = (int)substr($action['from_date'], 0, 2);
				$m1 = (int)substr($action['from_date'], 3, 2);
				$y1 = (int)substr($action['from_date'], 6, 4);

				$d2 = (int)substr($action['to_date'], 0, 2);
				$m2 = (int)substr($action['to_date'], 3, 2);
				$y2 = (int)substr($action['to_date'], 6, 4);

				$dateX = $yx."-".$mx."-".$dx;
				$date1 = $y1."-".$m1."-".$d1;
				$date2 = $y2."-".$m2."-".$d2;

				if($date1 < $dateX and $dateX < $date2) {
					$type = "now";
				}

				if($date1 > $dateX) {
					$type = "future";
				}

				if($dateX > $date2) {
					$type = "past";
				}

				echo "
					<div id='personalMenu'>
						<div id='newsSlider'>
				";

				$actionsResult = $mysqli->query("SELECT * FROM actions ORDER BY id DESC LIMIT 10");
				while($actions = $actionsResult->fetch_assoc()) {
					$j++;
					if($actions['from_date'] != $actions['to_date']) {
						$i1 = (int)substr($actions['from_date'], 3, 2) - 1;
						$i2 = (int)substr($actions['to_date'], 3, 2) - 1;
						$fd = substr($actions['from_date'], 0, 2)." ".$month[$i1]." ".substr($actions['from_date'], 6, 4);
						$td = substr($actions['to_date'], 0, 2)." ".$month[$i2]." ".substr($actions['to_date'], 6, 4);
						$d = $fd." — ".$td;
					} else {
						$i = (int)substr($actions['from_date'], 3, 2) - 1;
						$d = substr($actions['from_date'], 0, 2)." ".$month[$i]." ".substr($actions['from_date'], 6, 4);
					}

					echo "
						<a href='actions.php?id=".$actions['id']."'>
							<div class='newsPreview' id='newsPreview".$actions['id']."' "; if($j > 1) {echo "style='margin-left: 0;";} else {echo "style='margin: 0;";} if($actions['id'] == $_REQUEST['id']) {echo " background-color: #ededed;'";} else {echo "'";} echo ">
								<img src='img/photos/actions/".$actions['preview']."' />
								<br /><br />
								<div style='text-align: left;'>
									<span style='color: #df4e47; font-style: italic; font-size: 14px;'>".$d."</span>
									<p style='color: #4c4c4c; margin-top: 0;'>".$actions['header']."</p>
									<br />
									<div style='text-align: right;'><img src='img/system/arrow.png' /></div>
								</div>
							</div>
						</a>
					";
				}

				echo "
							<div style='width: 100%; height: 70px;'></div>
						</div>
					</div>

					<div id='personalContent'>
						<h2>".$action['header']."</h2>
						<p>".$action['text']."</p>
						<span style='font-style: italic; font-size: 14px;'>
				";

				switch($type) {
					case "now":
						echo "Срок проведения акции: ";
						break;
					case "future":
						echo "Акция будет проводиться: ";
						break;
					case "past":
						echo "Акция проводилась: ";
						break;
					default:
						echo "Срок проведения акции: ";
						break;
				}

				echo "
						<span style='color: #df4e47;'>".$date."</span></span>
				";

				$goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM action_goods WHERE action_id = '".$_REQUEST['id']."'");
				$goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

				if($goodsCount[0] > 0) {
					echo "<br /><br /><br /><h2>Акционные товары</h2>";

					$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE action_id = '".$_REQUEST['id']."'");
					while($actionGood = $actionGoodResult->fetch_assoc()) {
						$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$actionGood['good_id']."'");
						$good = $goodResult->fetch_assoc();

						$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
						$unit = $unitResult->fetch_assoc();

						$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
						$currency = $currencyResult->fetch_assoc();

						$price = $actionGood['price'] * $currency['rate'];
						$roubles = floor($price);
						$kopeck = round(($price - $roubles) * 100);
						if($kopeck == 100) {
							$kopeck = 0;
							$roubles ++;
						}

						if($roubles == 0 and $kopeck == 0) {
							$kopeck = 1;
						}

						echo "
							<div class='catalogueItem'>
								<div class='itemDescription'>
									<div class='catalogueIMG'>
										<a href='img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='img/catalogue/small/".$good['small']."' /></a>
										<img src='img/system/action.png' class='actionIMG' />
									</div>
									<div class='catalogueInfo'>
										<div class='catalogueName'>
											<div style='width: 5px; height: 30px; background-color: #df4e47; position: relative; float: left;'></div>
											<div style='margin-left: 15px;'>".$good['name']."</div>
											<div style='clear: both;'></div>
										</div>
										<div class='catalogueDescription'>
						";
						$strings = explode("<br />", $good['description']);
						for($i = 0; $i < count($strings); $i++) {
							$string = explode(':', $strings[$i]);
							if(count($string) > 1) {
								echo "<b>".$string[0].":</b>".$string[1]."<br />";
							} else {
								echo $string[0]."<br />";
							}
						}
						echo "
							<br />
							<b>Артикул: </b>".$good['code']."
							<br />
							<div id='goodPrice".$good['id']."'>
								<span><b>Стоимость за ".$unit['short_name'].": </b><span style='color: #df4e47; font-weight: bold;'>"; if($roubles > 0) {echo $roubles." руб. ";} echo ceil($kopeck)." коп.</span></span>
						";

						if($good['sketch'] != '') {
							echo "<br /><br /><a href='img/catalogue/sketch/".$good['sketch']."' class='lightview'><span class='sketchFont'>Чертёж</span></a>";
						}

						echo "
										</div>
									</div>
								</div>
								<div style='clear: both;'></div>
							</div>
						";

						if(isset($_SESSION['userID']) and $_SESSION['userID'] != 1) {
							echo "
								<div class='itemPurchase'>
									<img src='img/system/toBasket.png' id='toBasketIMG".$good['id']."' class='toBasketIMG' onmouseover='changeIcon(\"toBasketIMG".$good['id']."\", \"toBasketRed.png\", 0)' onmouseout='changeIcon(\"toBasketIMG".$good['id']."\", \"toBasket.png\", 0)' title='Добавить в корзину' onclick='addToBasket(\"".$good['id']."\", \"quantityInput".$good['id']."\", \"addingResult".$good['id']."\")' />
									<form method='post'>
										<label for='quantityInput".$good['id']."'>Кол-во в ".$unit['in_name'].":</label>
										<input type='number' id='quantityInput".$good['id']."' min='1' step='1' value='1' class='itemQuantityInput' />
									</form>
									<br />
									<div class='addingResult' id='addingResult".$good['id']."' onclick='hideBlock(\"addingResult".$good['id']."\")'></div>
								</div>

							";
						}

						echo "
							<div style='clear: both;'></div>
							<div style='width: 100%; height: 20px;'></div>
							<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;'></div>
							<div style='width: 100%; height: 20px;'></div>
						";
					}

					if(isset($_SESSION['userID']) and $_SESSION['userID'] != 1) {
						$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
						$discount = $discountResult->fetch_array(MYSQLI_NUM);

						if($discount[0] > 0) {
							echo "<b>Обратите внимание, ваша личная скидка, равная <span style='color: #df4e47;'>".$discount[0]."%</span>, при покупке акционных товаров <span style='color: #df4e47;'>не учитывается</span>.</b>";
						}
					} else {
						if($_SESSION['userID'] != 1) {
							echo "Чтобы получить возможность купить акционные в онлайн-режиме, необходимо <a href='personal/login.php'><span style='color: #df4e47; text-decoration: underline;'>войти на сайт</span></a>, либо <a href='personal/register.php'><span style='color: #df4e47; text-decoration: underline;'>зарегистрироваться</span></a>, если у вас ещё нет своей учётной записи.";
						}
					}
				}

				echo "
						<br /><br />
						<a href='actions.php'><span style='color: #df4e47; font-style: italic; font-size: 14px; text-decoration: underline;' class='yearFont'>Больше акций</span></a>
					</div>
				";
			}
		?>
	</div>

	<div style="clear: both;"></div>
	<div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="contacts.php?page=main">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="https://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>