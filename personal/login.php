<?php
session_start();
$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];

if(isset($_SESSION['userID'])) {
	header("Location: ../index.php");
}
?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Вход в учётную запись</title>

    <link rel='shortcut icon' href='../img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='../img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='../css/style.css'>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/menu.js"></script>
	<script type="text/javascript" src="../js/login.js"></script>
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
				<?php
					if(empty($_SESSION['userID'])) {
						echo "<a href='login.php'><img src='../img/system/loginRed.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"login.png\", 1)' onmouseout='changeIcon(\"loginIMG\", \"loginRed.png\", 1)' /></a>";
					} else {
						echo "<a href='../scripts/personal/logout.php'><img src='../img/system/exitRed.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exit.png\", 1)' onmouseout='changeIcon(\"exitIMG\", \"exitRed.png\", 1)' /></a>";
					}
				?>
			</div>
            <div id="menuLinks">
                <div class="menuLink" id="catalogueLink" onmouseover="showDropdownList('1', 'catalogueLink')">
                    <a href="../catalogue.php?type=fa&p=1" class="menuPoint">Каталог</a>
                    <img src="../img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
                    <a href="../about.php">О компании</a>
                    <img src="../img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="../news.php">Новости</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
                    <a href="../stores.php">Где купить</a>
                    <img src="../img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="../actions.php">Акции</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink')">
                    <a href="../partners.php">Партнерам</a>
                    <img src="../img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="contactsLink" onmouseover="showDropdownList('1', 'contactsLink')">
                    <a href="../contacts.php">Контакты</a>
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

	<div id="centralBlock">
		<div id="topSection">
			<h1>Вход в учётную запись</h1>
			<div id="breadCrumbs">
				<a href="../index.php"><span class="breadCrumbsText">Главная</span></a> > <a href="login.php"><span class="breadCrumbsText">Вход в учётную запись</span></a>
			</div>
		</div>

		<div id="loginStatus">
			<?php
				if(isset($_SESSION['loginError'])) {
					echo "<span style='color: #df4e47; font-size: 16px; font-style: italic;'>Вы неверно ввели логин (email) или пароль.</span><br/><br/>";
				}

			unset($_SESSION['loginError']);
			?>
		</div>

		<form id="loginForm" method="post" action="../scripts/personal/login.php" onsubmit="return loginCheck();">
			<label for="loginLoginInput">Логин или email:</label>
			<br />
			<input type="text" id="loginLoginInput" name="loginLogin" />
			<br /><br />
			<label for="loginPasswordInput">Пароль:</label>
			<br />
			<input type="password" id="loginPasswordInput" name="loginPassword" />
			<br /><br />
			<input type="submit" value="Войти" id="loginSubmit" onmouseover="buttonChange('loginSubmit', 1)" onmouseout="buttonChange('loginSubmit', 0)" />
		</form>

		<div style="margin-top: 40px; width: 100%;">
			<a href="register.php" class="basicLink">Ещё не зарегистрированы?</a>
			<br />
			<a href="recovery.php" class="basicLink">Забыли пароль?</a>
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