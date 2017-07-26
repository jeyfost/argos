<?php

session_start();
include("../scripts/connect.php");

if(!empty($_REQUEST['year'])) {
	$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE client = '1' AND year = '".$mysqli->real_escape_string($_REQUEST['year'])."'");
	$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

	if($newsCount[0] == 0) {
		header("Location: news.php");
	}
}

if(!empty($_REQUEST['id'])) {
	$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE client = '1' AND id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

	if($newsCount[0] == 0) {
		header("Location: news.php");
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

    <title>Новости для клиентов</title>

    <link rel='shortcut icon' href='../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../css/style.css'>
	<link rel="stylesheet" type="text/css" href="../js/lightview/css/lightview/lightview.css" />
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='../css/styleOpera.css'>";
		}
	?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../js/menu1.js"></script>
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src="../js/news.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="../js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="../js/lightview/js/lightview/lightview.js"></script>

	<style>
		#page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
		#page-preloader .spinner {width: 32px; height: 32px; position: absolute; left: 50%; top: 50%; background: url('../img/system/spinner.gif') no-repeat 50% 50%; margin: -16px 0 0 -16px;}
	</style>

	<script type="text/javascript">
        $(window).on('load', function () {
            var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
            $spinner.delay(500).fadeOut();
            $preloader.delay(850).fadeOut('slow');
        });
    </script>
</head>

<body>
	<div id="page-preloader"><span class="spinner"></span></div>

    <div id="menu">
        <div class="container" style="height: 100%;">
            <a href="../index.php"><img src="../img/system/logo.png" id="logo" /></a>
			<div id="personalButtons">
				<?php
					if(isset($_SESSION['userID'])) {
						echo "
							<div class='headerIcon'>
								<a href='../scripts/personal/logout.php'><img src='../img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exitRed.png\", 1)' onmouseout='changeIcon(\"exitIMG\", \"exit.png\", 1)' /></a>
							</div>
							<div class='headerIcon'>
								<a href='../personal/personal.php?section=1'><img src='../img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon(\"personalIMG\", \"personalRed.png\", 1)' onmouseout='changeIcon(\"personalIMG\", \"personal.png\", 1)' /></a>
							</div>
						";
						if($_SESSION['userID'] == 1) {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='../personal/orders.php?section=1&p=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon'>
										<a href='../personal/orders.php'><img src='../img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' /></a>
									</div>
								";
							}
						} else {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='../personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='../personal/basket.php'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' /></a>
									</div>
								";
							}
						}
					} else {
						echo "
							<div class='headerIcon'>
								<a href='../personal/login.php'><img src='../img/system/login.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"loginRed.png\", 1)' onmouseout='changeIcon(\"loginIMG\", \"login.png\", 1)' /></a>
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
					<a href="../catalogue/index.php?type=fa&p=1">Каталог</a>
					<img src="../img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
					<a href="../about/info.php">О компании</a>
					<img src="../img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLinkNotDD">
					<a href="../news.php">Новости</a>
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
					<a href="../stores/company.php">Где купить</a>
					<img src="../img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLinkNotDD">
					<a href="../actions.php">Акции</a>
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink', 'partnersLinkClientNews')">
					<a href="../partners/cooperation.php" style="color: #df4e47;">Партнерам</a>
					<img src="../img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="contactsLink" onmouseover="showDropdownList('1', 'contactsLink')">
					<a href="../contacts/stores.php">Контакты</a>
					<img src="../img/system/downArrow.png" />
				</div>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
        </div>
		<div id="menuIcon" onclick="showHideMobileMenu()"><img src="/img/system/mobile/menuIcon.png" title="Меню" /></div>
		<div id="mobileMenu">
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/catalogue/index.php?type=fa&p=1" class="mobileMenuPointBig">Каталог</a>
				<div class="subMenu">
					<a href="/catalogue/index.php?type=fa&p=1" class="mobileMenuPointSmall">- Мебельная фурнитура</a>
					<br />
					<a href="/catalogue/index.php?type=em&p=1" class="mobileMenuPointSmall">- Кромочные материалы</a>
					<br />
					<a href="/catalogue/index.php?type=ca&p=1" class="mobileMenuPointSmall">- Аксессуары для штор</a>
					<br />
					<a href="/catalogue/index.php?type=ht&p=1" class="mobileMenuPointSmall">- Ручной инструмент</a>
					<br />
					<a href="/catalogue/index.php?type=dg&p=1" class="mobileMenuPointSmall">- Сопутствующие товары</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/about/info.php" class="mobileMenuPointBig">О компании</a>
				<div class="subMenu">
					<a href="/about/info.php" class="mobileMenuPointSmall">- Общая информация</a>
					<br />
					<a href="/about/assortment.php" class="mobileMenuPointSmall">- Ассортимент</a>
					<br />
					<a href="/about/awards.php" class="mobileMenuPointSmall">- Достижения и награды</a>
					<br />
					<a href="/about/gallery.php" class="mobileMenuPointSmall">- Фотогалерея</a>
					<br />
					<a href="/about/vacancies.php" class="mobileMenuPointSmall">- Вакансии</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/news.php" class="mobileMenuPointBig">Новости</a>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/stores/company.php" class="mobileMenuPointBig">Где купить</a>
				<div class="subMenu">
					<a href="/stores/company.php" class="mobileMenuPointSmall">- Фирменная сеть</a>
					<br />
					<a href="/stores/representatives.php" class="mobileMenuPointSmall">- Партнёрская сеть</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/actions.php" class="mobileMenuPointBig">Акции</a>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/partners/cooperation.php" class="mobileMenuPointBig">Партнёрам</a>
				<div class="subMenu">
					<a href="/partners/cooperation.php" class="mobileMenuPointSmall">- Сотрудничество</a>
					<br />
					<a href="/partners/news.php" class="mobileMenuPointSmall">- Новости для клиентов</a>
				</div>
			</div>
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/contacts/stores.php" class="mobileMenuPointBig">Контакты</a>
				<div class="subMenu">
					<a href="/contacts/stores.php" class="mobileMenuPointSmall">- Магазины</a>
					<br />
					<a href="/contacts/main.php" class="mobileMenuPointSmall">- Головное предприятие</a>
					<br />
					<a href="/contacts/mail.php" class="mobileMenuPointSmall">- Обратная связь</a>
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
            <img src="../img/system/dropDownListArrow.png" id="dropDownArrow" />
        </div>
        <div id="dropDownList"></div>
    </div>
    <div id="menuShadow"></div>

	<div id="page">
		<div id="searchList"></div>
		<h1 style='margin-top: 80px;'>Новости для клиентов</h1>
		<div id='breadCrumbs'>
			<a href='../index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='cooperation.php'><span class='breadCrumbsText'>Партнёрам</span></a> > <a href='cooperation.php'><span class='breadCrumbsText'>Новости для клиентов</span></a>
		</div>

		<div id="personalMenu">
			<a href='cooperation.php'><div class='personalMenuLink' id='pbl1' onmouseover='buttonChange("pbl1", 1)' onmouseout='buttonChange("pbl1", 0)'>Сотрудничество</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='news.php'><div class='personalMenuLinkActive'>Новости для клиентов</div></a>
			<?php
				if(!empty($_REQUEST['id'])) {
					echo "<br /><br />";

					$newsResult = $mysqli->query("SELECT * FROM news WHERE client = '1' AND id = '".$mysqli->real_escape_string($_REQUEST['id'])."' ORDER BY id DESC");
					$news = $newsResult->fetch_assoc();

					$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
					$index = (int)substr($news['date'], 3, 2) - 1;
					$j = 0;

					$date = substr($news['date'], 0, 2)." ".$month[$index]." ".substr($news['date'], 6, 4);

					$yearNewsResult = $mysqli->query("SELECT * FROM news WHERE client = '1' AND year = '".$news['year']."' ORDER BY id DESC");
					while($yearNews = $yearNewsResult->fetch_assoc()) {
						$j++;
						$i = (int)substr($yearNews['date'], 3, 2) - 1;
						$d = substr($yearNews['date'], 0, 2) . " " . $month[$i] . " " . substr($yearNews['date'], 6, 4);

						echo "
							<a href='news.php?id=" . $yearNews['id'] . "'>
								<div class='newsPreview' id='newsPreview" . $yearNews['id'] . "' ";
						if ($j > 1) {
							echo "style='margin-left: 0;";
						} else {
							echo "style='margin: 0;";
						}
						if ($yearNews['id'] == $_REQUEST['id']) {
							echo " background-color: #ededed;'";
						} else {
							echo "'";
						}
						echo ">
									<img src='../img/photos/news/" . $yearNews['preview'] . "' />
									<br /><br />
									<div style='text-align: left;'>
										<span style='color: #df4e47; font-style: italic; font-size: 14px;'>" . $d . "</span>
										<p style='color: #4c4c4c; margin-top: 0;'>" . $yearNews['header'] . "</p>
										<br />
										<div style='text-align: right;'><img src='../img/system/arrow.png' /></div>
									</div>
								</div>
							</a>
						";
					}
				}
			?>
		</div>

		<div id="personalContent">
			<div style="width: 100%; text-align: right;">
				<span style='color: #4c4c4c; font-style: italic; font-size: 16px;'>Архив: </span>
				<?php
					$yearResult = $mysqli->query("SELECT DISTINCT year FROM news WHERE client = '1' ORDER BY year DESC");
					while($year = $yearResult->fetch_array(MYSQLI_NUM)) {
						echo "<a href='news.php?year=".$year[0]."'><span id='yearFont".$year[0]."' "; if($_REQUEST['year'] != $year[0]) {echo "style='font-style: italic; font-size: 14px; color: #4c4c4c; text-decoration: underline;' onmouseover='changeFont(\"yearFont".$year[0]."\", 1)' onmouseout='changeFont(\"yearFont".$year[0]."\", 0)'";} else {echo "style='font-style: italic; font-size: 14px; color: #df4e47;'";} echo "'>".$year[0]."</span></a> ";
					}
				?>
			</div>
			<div style="width: 100%; height: 1px; background-color: #c9c9c9; margin-top: 5px;"></div>
			<br />

			<?php
			if(empty($_REQUEST['id'])) {
				if(empty($_REQUEST['year'])) {
					$newsResult = $mysqli->query("SELECT * FROM news WHERE client = '1' ORDER BY id DESC");
				} else {
					$newsResult = $mysqli->query("SELECT * FROM news WHERE client = '1' AND year = '".$_REQUEST['year']."' ORDER BY id DESC");
				}

				while($news = $newsResult->fetch_assoc()) {
					$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
					$index = (int)substr($news['date'], 3, 2) - 1;

					$date = substr($news['date'], 0, 2)." ".$month[$index]." ".substr($news['date'], 6, 4);

					echo "
						<a href='news.php?id=".$news['id']."'>
							<div class='newsPreview' id='newsPreview".$news['id']."'>
								<img src='../img/photos/news/".$news['preview']."' />
								<br /><br />
								<div style='text-align: left;'>
									<span style='color: #df4e47; font-style: italic; font-size: 14px;'>".$date."</span>
									<p style='color: #4c4c4c; margin-top: 0;'>".$news['header']."</p>
									<br />
									<div style='text-align: right;'><img src='../img/system/arrow.png' /></div>
								</div>
							</div>
						</a>
					";
				}
			} else {
				echo "
					<span style='color: #df4e47; font-style: italic; font-size: 14px;'>".$date."</span>
					<br /><br />
					<h2>".$news['header']."</h2>
					<p>".$news['text']."</p>
					<a href='news.php'><span style='color: #df4e47; font-style: italic; font-size: 14px; text-decoration: underline;' class='yearFont'>Больше новостей</span></a>
					";
			}
			?>
		</div>
	</div>

	<div style="clear: both;"></div>
	<div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="contacts/main.php">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="https://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>