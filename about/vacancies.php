<?php

session_start();
include("../scripts/connect.php");

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

    <title>Вакансии</title>

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
	<script type="text/javascript" src="../js/about.js"></script>
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
										<a href='../personal/basket.php'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)' /></a>
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
					<a href="../catalogue.php?type=fa&p=1">Каталог</a>
					<img src="../img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink', 'aboutLinkVacancies')">
					<a href="../about/info.php" style="color: #df4e47;">О компании</a>
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
		<h1 style='margin-top: 80px;'>Вакансии</h1>
		<div id='breadCrumbs'>
			<a href='../index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='info.php'><span class='breadCrumbsText'>О компании</span></a> > <a href='vacancies.php'><span class='breadCrumbsText'>Вакансии</span></a>
		</div>

		<div id="personalMenu">
			<a href='info.php'><div class='personalMenuLink' id='pbl1' onmouseover='buttonChange("pbl1", 1)' onmouseout='buttonChange("pbl1", 0)'>Общая информация</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='assortment.php'><div class='personalMenuLink' id='pbl2' onmouseover='buttonChange("pbl2", 1)' onmouseout='buttonChange("pbl2", 0)'>Ассортимент</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='awards.php'><div class='personalMenuLink' id='pbl3' onmouseover='buttonChange("pbl3", 1)' onmouseout='buttonChange("pbl3", 0)'>Достижения и награды</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='gallery.php'><div class='personalMenuLink' id='pbl4' onmouseover='buttonChange("pbl4", 1)' onmouseout='buttonChange("pbl4", 0)'>Фотогалерея</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='vacancies.php'><div class='personalMenuLinkActive'>Вакансии</div></a>
		</div>

		<div id="personalContent">
			<?php
				$vacanciesCountResult = $mysqli->query("SELECT COUNT(id) FROM vacancies WHERE opened = '1'");
				$vacanciesCount = $vacanciesCountResult->fetch_array(MYSQLI_NUM);

				if($vacanciesCount[0] == 0) {
					echo "На данный момент открытых вакансий нет, но вы можете отправить нам своё резюме через форму ниже.";
				} else {
					echo "
						<span style='font-style: italic; font-size: 14px;'>Общее количество вакансий: <span style='color: #df4e47;'>".$vacanciesCount[0]."</span></span>
						<hr />
						<br />
					";

					$i = 0;

					$vacancyResult = $mysqli->query("SELECT * FROM vacancies WHERE opened = '1' ORDER BY id DESC");
					while($vacancy = $vacancyResult->fetch_assoc()) {
						$i++;

						$date = (int)substr($vacancy['created'], 0, 2)." ";

						switch(substr($vacancy['created'], 3, 2)) {
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
								$date .= "августа";
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
						}

						$date .= " ".substr($vacancy['created'], 6)." г.";

						echo "
							<h2>".$i.". ".$vacancy['position']."</h2>
							<span style='font-style: italic; font-size: 14px;'>Дата открытия вакансии: <span style='color: #df4e47;'>".$date."</span></span>
							<br /><br />
							".$vacancy['text']."
							<br /><br />
							<hr />
						";
					}
				}
			?>
			<br /><br />
			<b>Форма подачи резюме:</b>
			<br />
			<span style="font-size: 14px; font-style: italic;">Все поля являются обязательными для заполнения. Также необходимо прикрепить файл с вашим резюме.</span>
			<br />
			<div id="responseField" style="opacity: 1;">
				<?php
					if(isset($_SESSION['error'])) {
						switch($_SESSION['error']) {
							case "failed":
								echo "<br /><span style='color: #df4e47;'>При отправке резюме произошла ошибка. Повторите попытку.</span>";
								break;
							case "file":
								echo "<br /><span style='color: #df4e47;'>Вы не прикрепили ваше резюме, либо файл имеет недопустимый формат.</span>";
								break;
							case "empty":
								echo "<br /><span style='color: #df4e47;'>Заполните все поля.</span>";
								break;
							case "captcha":
								echo "<br /><span style='color: #df4e47;'>Вы не прошли проверку на робота.</span>";
								break;
							case "success":
								echo "<br /><span style='color: #53acff;'>Ваше резюме было успешно отправлено. Если оно нас заинтересует, мы с вами свяжемся.</span>";
								break;
							default: break;
						}

						unset($_SESSION['error']);
					}
				?>
			</div>
			<br /><br />
			<div id="CVForm">
				<form method="post" enctype="multipart/form-data" action="../scripts/about/sendCV.php" id="CV_Form">
					<label for="inputLastName">Фамилия:</label>
					<br />
					<input type="text" id="inputLastName" name="lastName" <?php if(isset($_SESSION['lastName'])) {echo "value = ".$_SESSION['lastName'];} ?> />
					<br /><br />
					<label for="inputFirstName">Имя:</label>
					<br />
					<input type="text" id="inputFirstName" name="firstName" <?php if(isset($_SESSION['firstName'])) {echo "value = ".$_SESSION['firstName'];} ?> />
					<br /><br />
					<label for="inputPatronymic">Отчество:</label>
					<br />
					<input type="text" id="inputPatronymic" name="patronymic" <?php if(isset($_SESSION['patronymic'])) {echo "value = ".$_SESSION['patronymic'];} ?> />
					<br /><br />
					<label for="inputLastName">Дата рождения:</label>
					<br />
					<select id="daySelect" name="day" class="CVSelect" style="margin: 0;"></select>
					<select id="monthSelect" name="month" class="CVSelect" onchange="changeDate()"></select>
					<select id="yearSelect" name="year" class="CVSelect" onchange="changeDate()"></select>
					<br /><br /><br />
					<label for="inputCity">Город проживания:</label>
					<br />
					<input type="text" id="inputCity" name="city" <?php if(isset($_SESSION['city'])) {echo "value = ".$_SESSION['city'];} ?> />
					<br /><br />
					<label for="inputPhone">Контактный телефон (с кодом):</label>
					<br />
					<input type="text" id="inputPhone" name="phone" <?php if(isset($_SESSION['phone'])) {echo "value = ".$_SESSION['phone'];} ?> />
					<br /><br />
					<label for="inputEmail">Email:</label>
					<br />
					<input type="text" id="inputEmail" name="email" <?php if(isset($_SESSION['email'])) {echo "value = ".$_SESSION['email'];} ?> />
					<br /><br />
					<label for="inputText">Вакансии, которые вас интересуют:</label>
					<br />
					<textarea id="inputText" name="text" onkeydown='textAreaHeight(this)'><?php if(isset($_SESSION['text'])) {echo $_SESSION['text'];} ?></textarea>
					<br /><br />
					<label for="inputCV">Прикрепите резюме:</label>
					<br />
					<input type="file" id="inputCV" name="CV" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" />
					<br />
					<div class="g-recaptcha" id="mailRecaptcha" data-sitekey="6Ld5MwATAAAAAN7L3GdbaS_dafMZdRicn-Jm8jVM"></div>
					<br />
					<input type="submit" id="mailSubmit" value="Отправить" onmouseover="buttonChange('mailSubmit', 1)" onmouseout="buttonChange('mailSubmit', 0)" style="float: left; margin-top: 20px;" />
				</form>

				<?php
					unset($_SESSION['lastName']);
					unset($_SESSION['firstName']);
					unset($_SESSION['patronymic']);
					unset($_SESSION['city']);
					unset($_SESSION['phone']);
					unset($_SESSION['email']);
					unset($_SESSION['text']);
				?>
			</div>
		</div>
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
	<script src='https://www.google.com/recaptcha/api.js?hl=ru'></script>

</body>

</html>