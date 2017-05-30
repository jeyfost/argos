<?php
	session_start();

	if(isset($_SESSION['userID'])) {
		header("Location: ../index.php");
	}
?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Создание учётной записи</title>

    <link rel='shortcut icon' href='../img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../css/style.css'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/menu1.js"></script>
	<script type="text/javascript" src="../js/register.js"></script>
	<script type="text/javascript" src="../js/common.js"></script>

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
				<div class="headerIcon">
					<a href='login.php'><img src='../img/system/loginRed.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon("loginIMG", "login.png", 1)' onmouseout='changeIcon("loginIMG", "loginRed.png", 1)' /></a>
				</div>
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

	<div id="page" style="margin-top: 80px;">
		<div id="searchList"></div>
		<div id="topSection">
			<h1>Создание учётной записи</h1>
			<div id="breadCrumbs">
				<a href="../index.php"><span class="breadCrumbsText">Главная</span></a> > <a href="register.php"><span class="breadCrumbsText">Создание учётной записи</span></a>
			</div>
		</div>

		<div id="registrationBlock" style="width: 100%;">
			<div id="registrationStatus">
				<?php
					if(isset($_SESSION['registration'])) {
						switch($_SESSION['registration']) {
							case "false":
								echo "При создании новой учётной записи произошла ошибка. Попробуйте снова.";
								break;
							case "captcha":
								echo "Вы не прошли проверку на робота.";
								break;
							case "login":
								echo "Вы не ввели логин либо ввели его в недопустимом формате.";
								break;
							case "loginDuplicate":
								echo "Введённый вами логин уже существует.";
								break;
							case "password":
								echo "Вы не ввели пароль.";
								break;
							case "email":
								echo "Вы не ввели email либо ввели его в недопустимом формате.";
								break;
							case "emailDuplicate":
								echo "Введённый вами email уже существует.";
								break;
							case "name":
								echo "Вы не указали контактное лицо.";
								break;
							case "phone":
								echo "Вы не ввели номер контактного телефона.";
								break;
							case "phoneDuplicate":
								echo "Введённый вами номер контактного телефона уже существует.";
								break;
							default: break;
						}
						unset($_SESSION['registration']);
						echo "<br /><br />";
					}
				?>
			</div>
			<div id="registrationContainer">
				<form id="registrationForm" method="post" action="../scripts/personal/register.php">
					<label for="registrationLoginInput">Логин:</label>
					<br />
					<input type="text" id="registrationLoginInput" name="registrationLogin" <?php if(isset($_SESSION['registrationLogin'])) {echo "value='".$_SESSION['registrationLogin']."'"; unset($_SESSION['registrationLogin']);} ?> />
					<br /><br />
					<label for="registrationPasswordInput">Пароль:</label>
					<br />
					<input type="password" id="registrationPasswordInput" name="registrationPassword" />
					<br /><br />
					<label for="registrationEmailInput">Email:</label>
					<br />
					<input type="text" id="registrationEmailInput" name="registrationEmail" <?php if(isset($_SESSION['registrationEmail'])) {echo "value='".$_SESSION['registrationEmail']."'"; unset($_SESSION['registrationEmail']);} ?> />
					<br /><br />
					<label for="registrationCompanyInput">Название организации:</label>
					<br />
					<input type="text" id="registrationCompanyInput" name="registrationCompany" <?php if(isset($_SESSION['registrationCompany'])) {echo "value='".$_SESSION['registrationCompany']."'"; unset($_SESSION['registrationCompany']);} ?> />
					<br /><br />
					<label for="registrationNameInput">Контактное лицо:</label>
					<br />
					<input type="text" id="registrationNameInput" name="registrationName" <?php if(isset($_SESSION['registrationName'])) {echo "value='".$_SESSION['registrationName']."'"; unset($_SESSION['registrationName']);} ?> />
					<br /><br />
					<label for="registrationPositionInput">Должность:</label>
					<br />
					<input type="text" id="registrationPositionInput" name="registrationPosition" <?php if(isset($_SESSION['registrationPosition'])) {echo "value='".$_SESSION['registrationPosition']."'"; unset($_SESSION['registrationPosition']);} ?> />
					<br /><br />
					<label for="registrationPhoneInput">Контактный телефон:</label>
					<br />
					<input type="text" id="registrationPhoneInput" name="registrationPhone" <?php if(isset($_SESSION['registrationPhone'])) {echo "value='".$_SESSION['registrationPhone']."'"; unset($_SESSION['registrationPhone']);} ?> />
					<br /><br />
					<div class="g-recaptcha" data-sitekey="6Ld5MwATAAAAAN7L3GdbaS_dafMZdRicn-Jm8jVM"></div>
					<br />
					<input type="submit" value="Зарегистрироваться" id="registrationSubmit" onmouseover="buttonChange('registrationSubmit', 1)" onmouseout="buttonChange('registrationSubmit', 0)" />
				</form>
			</div>
			<div id="registrationDescription">
				<span style="font-size: 24px;">Зачем нужна регитсрация?</span>
				<ul>
					<li>Вы получаете возможность онлайн-заказа товаров</li>
					<li>Каждая учётная запись имеет возможность подключения персональных скидок</li>
					<li>Вы сможете просматривать полную статистику совершённых заказов и потраченных средств</li>
				</ul>
			</div>
			<div style="clear: both;"></div>
		</div>

		<div style="margin-top: 40px; width: 100%;">
			<a href="login.php" class="basicLink">Уже зарегистрированы?</a>
			<br />
			<a href="recovery.php" class="basicLink">Забыли пароль?</a>
		</div>
		<div style="margin-top: 40px; height: 40px; width: 100%;"></div>
	</div>
	<div style="overflow: hidden;"></div>

	<div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="../contacts/main.php">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="https://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

	<script src="https://www.google.com/recaptcha/api.js?hl=ru"></script>

</body>

</html>
