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

    <title>Восстановление пароля</title>

    <link rel='shortcut icon' href='../img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../css/style.css'>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/menu1.js"></script>
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
        <div id="menuIcon"><img src="../img/system/mobile/menuIcon.png" title="Меню" /></div>
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
			<h1>Восстановление пароля</h1>
			<div id="breadCrumbs">
				<a href="../index.php"><span class="breadCrumbsText">Главная</span></a> > <a href="recovery.php"><span class="breadCrumbsText">Восстановление пароля</span></a>
			</div>
		</div>

		<div id="recoveryStatus">
			<?php
				if(isset($_SESSION['recovery'])) {
					switch($_SESSION['recovery']) {
						case "empty":
							echo "<span style='color: #df4e47; font-size: 16px; font-style: italic;'>Вы не ввели логин или email.</span><br/><br/>";
							break;
						case "failed":
							echo "<span style='color: #df4e47; font-size: 16px; font-style: italic;'>Вы ввели несуществующий логин или email.</span><br/><br/>";
							break;
						default: break;
					}
					unset($_SESSION['recovery']);
				}
			?>
		</div>

		<form id="loginForm" method="post" action="../scripts/personal/recovery.php">
			<label for="recoveryLoginInput">Логин или email:</label>
			<br />
			<input type="text" id="recoveryLoginInput" name="recoveryLogin" />
			<br /><br />
			<input type="submit" value="Восстановить" id="recoverySubmit" onmouseover="buttonChange('recoverySubmit', 1)" onmouseout="buttonChange('recoverySubmit', 0)" />
		</form>

		<div style="margin-top: 40px; width: 100%;">
			<a href="register.php" class="basicLink">Ещё не зарегистрированы?</a>
			<br />
			<a href="login.php" class="basicLink">Я помню пароль!</a>
		</div>
	</div>
	<div style="overflow: hidden;"></div>

	<div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="../contacts.php?page=main">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="http://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>
