<?php

session_start();
include("../scripts/connect.php");
include("../layouts/footer.php");

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
 	<meta name="description" content="Компания Аргос-ФМ — это надёжный партнёр в области поставок мебельной фурнитуры. Мы занимаемся комплексными поставками комплектующих для мебели как на большинство ведущих предприятий Беларуси, так и на небольшие частные мебельные производства. Помимо оптовых продаж мы занимаемся реализацией наших товаров в розницу в г. Могилёве.">

    <title>Информация о компании Аргос-ФМ</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/style.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />
    <link rel="stylesheet" href="/js/font-awesome-4.7.0/css/font-awesome.min.css">
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='/css/styleOpera.css'>";
		}
	?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/menu1.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>

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

<body>
	<div id="page-preloader"><span class="spinner"></span></div>

    <div id="menu">
        <div class="container" style="height: 100%;">
            <a href="/"><img src="/img/system/logo.png" id="logo" /></a>
			<div id="personalButtons">
				<?php
					if(isset($_SESSION['userID'])) {
						echo "
							<div class='headerIcon'>
								<a href='/scripts/personal/logout.php'><img src='/img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exitRed.png\")' onmouseout='changeIcon(\"exitIMG\", \"exit.png\")' /></a>
							</div>
							<div class='headerIcon'>
								<a href='/personal/personal.php?section=1'><img src='/img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon(\"personalIMG\", \"personalRed.png\")' onmouseout='changeIcon(\"personalIMG\", \"personal.png\")' /></a>
							</div>
						";
						if($_SESSION['userID'] == 1) {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='/personal/orders.php?section=1&p=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")'><img src='/img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon'>
										<a href='/personal/orders.php'><img src='/img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")' /></a>
									</div>
								";
							}
						} else {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='/personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")'><img src='/img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='/personal/basket.php'><img src='/img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")' /></a>
									</div>
								";
							}
						}
					} else {
						echo "
							<div class='headerIcon'>
								<a href='/personal/login.php'><img src='/img/system/login.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"loginRed.png\")' onmouseout='changeIcon(\"loginIMG\", \"login.png\")' /></a>
							</div>
						";
					}
					echo "
						<div id='searchBlock'>
							<form id='searchForm' method='post' action='/search/'>
								<input type='text' id='searchFieldInput' name='searchField' value='Поиск...' onkeyup='queryToSession()' />
							</form>
						</div>
					";
					echo "<div style='clear: both;'></div>";
				?>
			</div>
			<div id="menuLinks">
				<div class="menuLink" id="catalogueLink" onmouseover="showDropdownList('1', 'catalogueLink')">
					<a href="/catalogue/index.php?type=fa&p=1">Каталог</a>
					<img src="/img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink', 'aboutLinkCommon')">
					<a href="/about/info.php" style="color: #ff282b;">О компании</a>
					<img src="/img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLinkNotDD">
					<a href="/news.php">Новости</a>
					<span class="slash"> /</span>
				</div>
                <!--
				<div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
					<a href="/stores/company.php">Где купить</a>
					<img src="/img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				-->
				<div class="menuLinkNotDD">
					<a href="/actions.php">Акции</a>
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink')">
					<a href="/partners/cooperation.php">Партнерам</a>
					<img src="/img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="contactsLink" onmouseover="showDropdownList('1', 'contactsLink')">
					<a href="/contacts/stores.php">Контакты</a>
					<img src="/img/system/downArrow.png" />
				</div>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
        </div>
		<div id="menuIcon" onclick="showHideMobileMenu()"><img src="/img/system/mobile/menuIcon.png" title="Меню" /></div>
		<div id="mobileMenu">
            <?php
                if(empty($_SESSION['userID'])) {
                    echo "
                            <div class='mobileMenuItem' style='margin-top: 0;'>
                                <a href='/personal/login.php' class='mobileMenuPointBig'>Войти</a>
                            </div>
                            <hr />
                        ";
                }
            ?>

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
            <!--
			<hr />
			<div class="mobileMenuItem" style="margin-top: 0;">
				<a href="/stores/company.php" class="mobileMenuPointBig">Где купить</a>
				<div class="subMenu">
					<a href="/stores/company.php" class="mobileMenuPointSmall">- Фирменная сеть</a>
					<br />
					<a href="/stores/representatives.php" class="mobileMenuPointSmall">- Партнёрская сеть</a>
				</div>
			</div>
			-->
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
					<a href="/contacts/stores.php" class="mobileMenuPointSmall">- Торговые объекты</a>
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
            <img src="/img/system/dropDownListArrow.png" id="dropDownArrow" />
        </div>
        <div id="dropDownList"></div>
    </div>
    <div id="menuShadow"></div>

	<div id="page">
		<div id="searchList"></div>
		<h1 style='margin-top: 80px;'>Информация о компании <span style="color: #ff282b;"> Аргос-ФМ</span></h1>
		<div id='breadCrumbs'>
			<a href='/'><span class='breadCrumbsText'>Главная</span></a> > <a href='info.php'><span class='breadCrumbsText'>О компании</span></a> > <a href='info.php'><span class='breadCrumbsText'>Основная информация</span></a>
		</div>

		<div id="personalMenu">
			<a href='info.php'><div class='personalMenuLinkActive'>Общая информация</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='assortment.php'><div class='personalMenuLink' id='pbl2' onmouseover='buttonChange("pbl2", 1)' onmouseout='buttonChange("pbl2", 0)'>Ассортимент</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='awards.php'><div class='personalMenuLink' id='pbl3' onmouseover='buttonChange("pbl3", 1)' onmouseout='buttonChange("pbl3", 0)'>Достижения и награды</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='gallery.php'><div class='personalMenuLink' id='pbl4' onmouseover='buttonChange("pbl4", 1)' onmouseout='buttonChange("pbl4", 0)'>Фотогалерея</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='vacancies.php'><div class='personalMenuLink' id='pbl5' onmouseover='buttonChange("pbl5", 1)' onmouseout='buttonChange("pbl5", 0)'>Вакансии</div></a>
		</div>

		<div id="personalContent" style="text-align: justify;">
            <p>Компания <span style="color: #fe2427;"><b>«Аргос-ФМ»</b></span> образована в 2008 году. За время  работы наше предприятие завоевало репутацию ответственного и надежного  поставщика фурнитуры и комплектующих для многочисленных  мебельных  производств  Республики Беларусь. Все  – от крупного мебельного предприятия до обычного домашнего мастера-умельца – находят  у нас необходимые комплектующие, инструмент и материалы для своего производства. Качество по лучшей цене – вот девиз нашего предприятия. Ведь не секрет, что долговечность и функциональность мебели напрямую зависит от  надежной фурнитуры и комплектующих. И при этом мы стремимся предложить лучшие цены.</p>
            <p><span style="color: #fe2427;"><b>«Аргос-ФМ»</b></span> является официальным  представителем многих ведущих брендов и производителей мебельной фурнитуры, комплектующих, мебельной кромки, инструмента, а также шторной фурнитуры и аксессуаров. Широкая география прямых поставок: Европа, Турция, Китай, Россия – позволяет всегда иметь в наличии большой  ассортимент продукции. Прямой контакт с производителями комплектующих и фурнитуры   позволяет постоянно совершенствовать качество изделий и работать над новыми образцами.</p>
            <p>Сегодня предприятие имеет большой шоу-рум, оборудованные складские помещения, два специализированных торговых объекта. Опытные сотрудники всегда придут на помощь при выборе необходимых товаров.  Ассортимент включает свыше 1000 разновидностей мебельных ручек, огромный выбор мебельных опор, кухонные аксессуары и комплектующие, различные системы крепежа, кромочные материалы, направляющие для выдвижных ящиков, комплектующие для шкафов-купе, механизмы и фурнитура для раздвижных столов, мебельные петли, замки, крючки, профили, светодиодные светильники,  декоративные элементы для мебели, метизная продукция, инструмент, шторная фурнитура и аксессуары, отделочные и упаковочные материалы и многое другое.</p>
            <p>Для оптовых покупателей действует система скидок и дополнительных бонусов. Мы  обеспечиваем доставку по всей территории Республики Беларусь.</p>
            <p>Широкий ассортимент продукции, оперативность поставок, общение с ответственными и доброжелательными специалистами убедят вас, что <span style="color: #fe2427;"><b>«Аргос-ФМ»</b></span>  –  отличный выбор.</p>
            </p>
		</div>
	</div>

	<div style="clear: both;"></div>
	<div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
		<?= footer() ?>
	</div>

</body>

</html>