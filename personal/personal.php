<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../index.php");
}

if($_SESSION['userID'] == 1) {
	if($_REQUEST['section'] != 1 and $_REQUEST['section'] != 2) {
		header("Location: personal.php?section=1");
	}
} else {
	if($_REQUEST['section'] != 1 and $_REQUEST['section'] != 2 and $_REQUEST['section'] != 3) {
		header("Location: personal.php?section=1");
	}
}

include("../scripts/connect.php");

if($_SESSION['userID'] == 1) {
	if(!empty($_REQUEST['user'])) {
		if($_REQUEST['section'] != 2) {
			header("Location: personal.php?section=2");
		} else {
			$userCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE id = '".$mysqli->real_escape_string($_REQUEST['user'])."'");
			$userCheck = $userCheckResult->fetch_array(MYSQLI_NUM);

			if($userCheck[0] == 0) {
				header("Location: personal.php?section=2");
			}
		}
	} else {
		if($_REQUEST['section'] == 2) {
			if(empty($_REQUEST['p'])) {
				header("Location: personal.php?section=2&p=1");
			} else {
				if(empty($_REQUEST['user'])) {
					$quantityResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE id <> '1' AND activated = '1'");
					$quantity = $quantityResult->fetch_array(MYSQLI_NUM);

					if($quantity[0] > 10) {
						if($quantity[0] % 10 != 0) {
							$numbers = intval(($quantity[0] / 10) + 1);
						} else {
							$numbers = intval($quantity[0] / 10);
						}
					} else {
						$numbers = 1;
					}

					$page = $mysqli->real_escape_string($_REQUEST['p']);
					$start = $page * 10 - 10;

					if($page > $numbers or $page <= 0) {
						header("Location: personal.php?section=2&p=1");
					}
				} else {
					$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$mysqli->real_escape_string($_REQUEST['user'])."'");
					if($userResult->num_rows == 0) {
						header("Location: personal.php?section=2&p=1");
					}
				}
			}
		}
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

    <title><?php if($_SESSION['userID'] == 1) {echo "Управление сайтом";} else {echo "Личный кабинет";} ?></title>

    <link rel='shortcut icon' href='../img/icons/favicon.ico' type='image/x-icon'>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel='stylesheet' media='screen' type='text/css' href='../css/style.css'>
	<link rel="stylesheet" type="text/css" href="../js/lightview/css/lightview/lightview.css" />
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='../css/styleOpera.css'>";
		}
	?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/menu1.js"></script>
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src="../js/personal.js"></script>
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
				<div class='headerIcon'>
					<a href='../scripts/personal/logout.php'><img src='../img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon("exitIMG", "exitRed.png", 1)' onmouseout='changeIcon("exitIMG", "exit.png", 1)' /></a>
				</div>
				<div class='headerIcon'>
					<a href='../personal/personal.php?section=1'><img src='../img/system/personalRed.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon("personalIMG", "personal.png", 1)' onmouseout='changeIcon("personalIMG", "personalRed.png", 1)' /></a>
				</div>
				<?php
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
				?>
				<div id='searchBlock'>
					<form method='post'>
						<input type='text' id='searchFieldInput' name=searchField' value='Поиск...' />
					</form>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div id="menuLinks">
				<div class="menuLink" id="catalogueLink" onmouseover="showDropdownList('1', 'catalogueLink')">
					<a href="../catalogue.php?type=fa&p=1" class="menuPoint">Каталог</a>
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
                <div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink')">
                    <a href="../partners/cooperation.php">Партнерам</a>
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
				<a href="/catalogue.php?type=fa&p=1" class="mobileMenuPointBig">Каталог</a>
				<div class="subMenu">
					<a href="/catalogue.php?type=fa&p=1" class="mobileMenuPointSmall">- Мебельная фурнитура</a>
					<br />
					<a href="/catalogue.php?type=em&p=1" class="mobileMenuPointSmall">- Кромочные материалы</a>
					<br />
					<a href="/catalogue.php?type=ca&p=1" class="mobileMenuPointSmall">- Аксессуары для штор</a>
					<br />
					<a href="/catalogue.php?type=dg&p=1" class="mobileMenuPointSmall">- Сопутствующие товары</a>
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

		<h1 style='margin-top: 80px;'><?php if($_SESSION['userID'] == 1) {echo "Управление сайтом";} else {echo "Личный кабинет";} ?></h1>
		<div id='breadCrumbs'>
			<a href='../index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='personal.php?section=1'><span class='breadCrumbsText'><?php if($_SESSION['userID'] == 1) {echo "Управление сайтом";} else {echo "Личный кабинет";} ?></span></a> >
			<?php
				if($_SESSION['userID'] == 1) {
					switch($_REQUEST['section']) {
						case 1:
							echo "<a href='personal.php?section=1'><span class='breadCrumbsText'>Установка курсов валют</span></a>";
							break;
						case 2:
							echo "<a href='personal.php?section=2&p=1'><span class='breadCrumbsText'>Управление пользователями</span></a>";
							if(!empty($_REQUEST['user'])) {
								echo " > <a href='personal.php?section=2&user=".$_REQUEST['user']."'><span class='breadCrumbsText'>Редактирование данных пользователя</span></a>";
							}
							break;
						default: break;
					}
				} else {
					switch($_REQUEST['section']) {
						case 1:
							echo "<a href='personal.php?section=1'><span class='breadCrumbsText'>Личные данные</span></a>";
							break;
						case 2:
							echo "<a href='personal.php?section=2'><span class='breadCrumbsText'>Изменение email адреса</span></a>";
							break;
						case 3:
							echo "<a href='personal.php?section=3'><span class='breadCrumbsText'>Изменение пароля</span></a>";
							break;
						default: break;
					}
				}
			?>
		</div>

		<?php
			if($_SESSION['userID'] == 1) {
				echo "
					<div id='personalMenu'>
						<a href='personal.php?section=1'><div "; if($_REQUEST['section'] == 1) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='p1' onmouseover='buttonChange(\"p1\", 1)' onmouseout='buttonChange(\"p1\", 0)'";} echo ">Курсы валют</div></a>
						<div style='width: 100%; height: 5px;'></div>
						<a href='personal.php?section=2&p=1'><div "; if($_REQUEST['section'] == 2) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='p2' onmouseover='buttonChange(\"p2\", 1)' onmouseout='buttonChange(\"p2\", 0)'";} echo ">Управление пользователями</div></a>
						<div style='width: 100%; height: 5px;'></div>
						<a href='../admin'><div class='personalMenuLink' id='p3' onmouseover='buttonChange(\"p3\", 1)' onmouseout='buttonChange(\"p3\", 0)'>Панель администрирования</div></a>
					</div>
					<div id='personalContent'>
						<div id='goodResponseField'></div>
				";

				switch($_REQUEST['section']) {
					case 1:
						echo "<form method='post' name='currencyForm'>";

						$currencyResult = $mysqli->query("SELECT * FROM currency");
						while($currency = $currencyResult->fetch_assoc()) {
							echo "
								<label for='currencyInput".$currency['id']."'>1 ".$currency['currency_name'].":</label>
								<br />
								<input type='number' min='0.00001' step='0.00001' id='currencyInput".$currency['id']."' value='".$currency['rate']."' "; if($currency['code'] == "BYN") {echo "readonly";} echo " />
								<br /><br />
							";
						}

						echo "
									<input type='button' value='Установить свои курсы' id='personalSubmit' onmouseover='buttonChange(\"personalSubmit\", 1)' onmouseout='buttonChange(\"personalSubmit\", 0)' onclick='setRates()' />
									<br /><br />
									<input type='button' value='Установить курсы нацбанка' id='personalBankSubmit' onmouseover='buttonChange(\"personalBankSubmit\", 1)' onmouseout='buttonChange(\"personalBankSubmit\", 0)' onclick='setOfficialRates()' />
								</form>
							</div>
						";
						break;
					case 2:
						if(empty($_REQUEST['user']))
						{
							if(!isset($_SESSION['sort'])) {
								$_SESSION['sort'] = "login";
							}

							if(!isset($_SESSION['sort_type'])) {
								$_SESSION['sort_type'] = "ASC";
							}

							$count = 0;
							$usersResult = $mysqli->query("SELECT * FROM users WHERE id <> '1' AND activated = '1' ORDER BY ".$_SESSION['sort']." ".$_SESSION['sort_type']." LIMIT ".$start.", 10");

							echo "
								<div style='height: 10px; width: 100%;'></div>
								<div id='innerSearch'>
									<form method='post'>
										<input type='text' id='innerSearchInput' value='Поиск пользователей...' />
									</form>
								</div>
								<div id='innerSearchList'></div>
								<div style='overflow: hidden;'></div>
								<br /><br />
								<table>
									<tr class='headTR'>
										<td id='td1' onclick='sortBy(\"id\")' title='Сортировать по id' nowrap>ID"; if($_SESSION['sort'] == "id") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td2' onclick='sortBy(\"login\")' title='Сортировать по логину' nowrap>Логин"; if($_SESSION['sort'] == "login") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td3' onclick='sortBy(\"email\")' title='Сортировать по email' nowrap>Email"; if($_SESSION['sort'] == "email") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td4' onclick='sortBy(\"name\")' title='Сортировать по имени' nowrap>Имя"; if($_SESSION['sort'] == "name") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td5' onclick='sortBy(\"company\")' title='Сортировать по названию организации' nowrap>Организация"; if($_SESSION['sort'] == "company") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td6' onclick='sortBy(\"position\")' title='Сортировать по должности' nowrap>Должность"; if($_SESSION['sort'] == "position") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td7' onclick='sortBy(\"discount\")' title='Сортировать по личной скидке' nowrap>Скидка"; if($_SESSION['sort'] == "discount") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td8' onclick='sortBy(\"registration_date\")' title='Сортировать по дате регистрации' nowrap>Дата регистрации"; if($_SESSION['sort'] == "registration_date") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td9' onclick='sortBy(\"last_login\")' title='Сортировать по дате последнего визита' nowrap>Последний визит"; if($_SESSION['sort'] == "last_login") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td id='td10' onclick='sortBy(\"logins_count\")' title='Сортировать по количеству просмотренных страниц' nowrap>Просмотрено страниц"; if($_SESSION['sort'] == "logins_count") {if($_SESSION['sort_type'] == "ASC") {echo "<span style='font-size: 12px;'> &#9650;</span>";} else {echo "<span style='font-size: 12px;'> &#9660;</span>";}} echo "</td>
										<td style='cursor: default;'>Редактирование</td>
									</tr>
							";

							while($users = $usersResult->fetch_assoc()) {
								$count++;

								echo "
									<tr"; if($count % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
										<td style='text-align: center;'>".$users['id']."</td>
										<td>".$users['login']."</td>
										<td style='text-align: center;'><a href='email.php?id=".$users['id']."' class='basicLink' style='font-size: 17px;' title='Отправить email'>".$users['email']."</a></td>
										<td>".$users['name']."</td>
										<td>".$users['company']."</td>
										<td>".$users['position']."</td>
										<td style='text-align: center;'>".$users['discount']."%</td>
										<td>".$users['registration_date']."</td>
										<td>".$users['last_login']."</td>
										<td style='text-align: center;'>".$users['logins_count']."</td>
										<td style='text-align: center;'><a href='personal.php?section=2&user=".$users['id']."'>Редактировать</a></td>
									</tr>
								";
							}

							echo "</table>";

							echo "<div id='pageNumbers'>";

							if($numbers > 1) {
								$uri = explode("&p=", $_SERVER['REQUEST_URI']);
								$link = $uri[0]."&p=";
								if($numbers <= 7) {
									echo "<br /><br />";

									if($_REQUEST['p'] == 1) {
										echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
									} else {
										echo "<a href='".$link.($_REQUEST['p'] - 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>";
									}

									for($i = 1; $i <= $numbers; $i++) {
										if($_REQUEST['p'] != $i) {
											echo "<a href='".$link.$i."' class='noBorder'>";
										}

										echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

										if($_REQUEST['p'] != $i) {
											echo "</a>";
										}
									}

									if($_REQUEST['p'] == $numbers) {
										echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
									} else {
										echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
									}

									echo "</div>";

								} else {
									if($_REQUEST['p'] < 5) {
										if($_REQUEST['p'] == 1) {
											echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
										} else {
											echo "<a href='".$link.($_REQUEST['p'] - 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>";
										}

										for($i = 1; $i <= 5; $i++) {
											if($_REQUEST['p'] != $i) {
												echo "<a href='".$link.$i."' class='noBorder'>";
											}

											echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

											if($_REQUEST['p'] != $i) {
												echo "</a>";
											}
										}

										echo "<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
										echo "<a href='".$link.$numbers."' class='noBorder'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>";

										if($_REQUEST['p'] == $numbers) {
											echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
										} else {
											echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
										}

										echo "</div>";
									} else {
										$check = $numbers - 3;

										if($_REQUEST['p'] >= 5 and $_REQUEST['p'] < $check) {
											echo "
												<br /><br />
												<div id='pageNumbers'>
													<a href='".$link.($_REQUEST['p'] - 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>
													<a href='".$link."1' class='noBorder'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='goodStyleRed' id='pbt1'>1</span></div></a>
													<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
													<a href='".$link.($_REQUEST['p'] - 1)."' class='noBorder'><div id='pb".($_REQUEST['p'] - 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($_REQUEST['p'] - 1)."\", \"pbt".($_REQUEST['p'] - 1)."\")' onmouseout='pageBlock(0, \"pb".($_REQUEST['p'] - 1)."\", \"pbt".($_REQUEST['p'] - 1)."\")'><span class='goodStyleRed' id='pbt".($_REQUEST['p'] - 1)."'>".($_REQUEST['p'] - 1)."</span></div></a>
													<div class='pageNumberBlockActive'><span class='goodStyleWhite'>".$_REQUEST['p']."</span></div>
													<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div id='pb".($_REQUEST['p'] + 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($_REQUEST['p'] + 1)."\", \"pbt".($_REQUEST['p'] + 1)."\")' onmouseout='pageBlock(0, \"pb".($_REQUEST['p'] + 1)."\", \"pbt".($_REQUEST['p'] + 1)."\")'><span class='goodStyleRed' id='pbt".($_REQUEST['p'] + 1)."'>".($_REQUEST['p'] + 1)."</span></div></a>
													<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
													<a href='".$link.$numbers."' class='noBorder'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>
													<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>
												</div>
											";
										} else {
											echo "
												<br /><br />
												<div id='pageNumbers'>
													<a href='".$link.($_REQUEST['p'] - 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>
													<a href='".$link."1' class='noBorder'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='goodStyleRed' id='pbt1'>1</span></div></a>
													<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
											";

											for($i = ($numbers - 4); $i <= $numbers; $i++) {
												if($_REQUEST['p'] != $i) {
													echo "<a href='".$link.$i."' class='noBorder'>";
												}

												echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

												if($_REQUEST['p'] != $i) {
													echo "</a>";
												}
											}

											if($_REQUEST['p'] == $numbers) {
												echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
											} else {
												echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
											}
										}
									}
								}
							}

							echo "</div><div style='clear: both;'></div>";
						} else {
							$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$mysqli->real_escape_string($_REQUEST['user'])."'");
							$user = $userResult->fetch_assoc();

							echo "
								<form method='post'>
									<label for='userLoginInput'>Логин:</label>
									<br />
									<input type='text' id='userLoginInput' value='".$user['login']."' />
									<br /><br />
									<label for='userPasswordInput'>Пароль:</label>
									<br />
									<input type='password' id='userPasswordInput' value='' />
									<br /><br />
									<label for='userEmailInput'>Email:</label>
									<br />
									<input type='text' id='userEmailInput' value='".$user['email']."' />
									<br />
									<a class='basicLink' href='email.php?id=".$user['id']."'>Отправить email этому клиенту</a>
									<br /><br />
									<label for='userCompanyInput'>Название компании:</label>
									<br />
									<input type='text' id='userCompanyInput' value='".$user['company']."' />
									<br /><br />
									<label for='userNameInput'>Контактное лицо:</label>
									<br />
									<input type='text' id='userNameInput' value='".$user['name']."' />
									<br /><br />
									<label for='userPositionInput'>Должность:</label>
									<br />
									<input type='text' id='userPositionInput' value='".$user['position']."' />
									<br /><br />
									<label for='userPhoneInput'>Номер телефона:</label>
									<br />
									<input type='text' id='userPhoneInput' value='".$user['phone']."' />
									<br /><br />
									<label for='userDiscountInput'>Скидка в %:</label>
									<br />
									<input type='number' id='userDiscountInput' min='0.01' max='99.99' step='0.01' value='".$user['discount']."' />
									<br /><br />
									<div id='responseFiled'></div>
									<input type='button' value='Редактировать' id='personalSubmit' onmouseover='buttonChange(\"personalSubmit\", 1)' onmouseout='buttonChange(\"personalSubmit\", 0)' onclick='adminEditUser(\"".$_REQUEST['user']."\")' />
								</form>
							";
						}
						break;
					default: break;
				}
			} else {
				echo "
					<div id='personalMenu'>
						<a href='personal.php?section=1'><div "; if($_REQUEST['section'] == 1) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb1' onmouseover='buttonChange(\"pb1\", 1)' onmouseout='buttonChange(\"pb1\", 0)'";} echo ">Личные данные</div></a>
						<div style='width: 100%; height: 5px;'></div>
						<a href='personal.php?section=2'><div "; if($_REQUEST['section'] == 2) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb2' onmouseover='buttonChange(\"pb2\", 1)' onmouseout='buttonChange(\"pb2\", 0)'";} echo ">Изменить email</div></a>
						<div style='width: 100%; height: 5px;'></div>
						<a href='personal.php?section=3'><div "; if($_REQUEST['section'] == 3) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb3' onmouseover='buttonChange(\"pb3\", 1)' onmouseout='buttonChange(\"pb3\", 0)'";} echo ">Изменить пароль</div></a>
					</div>
					<div id='personalContent'>
						<div id='goodResponseField'></div>
				";

				$personalResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
				$personal = $personalResult->fetch_assoc();

				switch($_REQUEST['section']) {
					case 1:
						echo "
							<form method='post'>
								<label for='personalCompanyInput'>Название компании:</label>
								<br />
								<input type='text' id='personalCompanyInput' name='personalCompany' value='".$personal['company']."' />
								<br /><br />
								<label for='personalNameInput'>Контактное лицо:</label>
								<br />
								<input type='text' id='personalNameInput' name='personalName' value='".$personal['name']."' />
								<br /><br />
								<label for='personalPositionInput'>Должность:</label>
								<br />
								<input type='text' id='personalPositionInput' name='personalPosition' value='".$personal['position']."' />
								<br /><br />
								<label for='personalPhoneInput'>Номер телефона:</label>
								<br />
								<input type='text' id='personalPhoneInput' name='personalPhone' value='".$personal['phone']."' />
								<br /><br />
								<label>Ваша личная скидка на все товары:</label>
								<br />
								<input type='text' value='".$personal['discount']."%' readonly style='background-color: #ddd; border: none;'>
								<br /><br />
								<input type='button' value='Редактировать' id='personalSubmit' onmouseover='buttonChange(\"personalSubmit\", 1)' onmouseout='buttonChange(\"personalSubmit\", 0)' onclick='editUserInfo()' />
							</form>
						";
						break;
					case 2:
						if(isset($_SESSION['editEmail'])) {
							switch($_SESSION['editEmail']) {
								case "ok":
									echo "<span style='color: #53acff;'>Адрес электронной почты был успешно изменён.</span>";
									break;
								case "failed":
									echo "<span style='color: #df4e47;'>Произошла ошибка. Попробуйте снова.</span>";
									break;
								default: break;
							}
							echo "<br /><br />";
							unset($_SESSION['editEmail']);
						}
						echo "
							<form method='post'>
								<label for='personalEmailInput'>Новый email адрес:</label>
								<br />
								<input type='text' id='personalEmailInput' value='".$personal['email']."' />
								<br /><br />
								<input type='button' value='Редактировать' id='personalSubmit' onmouseover='buttonChange(\"personalSubmit\", 1)' onmouseout='buttonChange(\"personalSubmit\", 0)' onclick='editUserEmail()' />
							</form>
						";
						break;
					case 3:
						echo "
							<form method='post'>
								<label for='personalPasswordInput'>Новый пароль:</label>
								<br />
								<input type='password' id='personalPasswordInput' />
								<br /><br />
								<label for='personalPasswordConfirmInput'>Подтвердите новый пароль:</label>
								<br />
								<input type='password' id='personalPasswordConfirmInput' />
								<br /><br />
								<input type='button' value='Изменить' id='personalSubmit' onmouseover='buttonChange(\"personalSubmit\", 1)' onmouseout='buttonChange(\"personalSubmit\", 0)' onclick='editUserPassword()' />
							</form>
						";
						break;
					default:
						break;
				}

				echo "</div>";
			}

		?>
	</div>

	<div style="clear: both;"></div>
	<div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="../contacts/main.php">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="https://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>