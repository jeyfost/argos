<?php

session_start();

include ("scripts/connect.php");
include ("layouts/footer.php");

if(!empty($_REQUEST['year'])) {
	$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE year = '".$mysqli->real_escape_string($_REQUEST['year'])."'");
	$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

	if($newsCount[0] == 0) {
		header("Location: news.php?p=1");
	}
}

if(empty($_REQUEST['year'])) {
    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM news");
} else {
    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE year = '".$mysqli->real_escape_string($_REQUEST['year'])."'");
}

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

if(!empty($_REQUEST['id'])) {
	$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

	if($newsCount[0] == 0) {
		header("Location: news.php?p=1");
	}

	$newsResult = $mysqli->query("SELECT * FROM news WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$news = $newsResult->fetch_assoc();
} else {
    if(empty($_REQUEST['p'])) {
        $parameter = explode("?", $_SERVER['REQUEST_URI']);

        if(empty($parameter[1])) {
            header("Location: news.php?p=1");
        } else {
            header("Location: ".$_SERVER['REQUEST_URI']."&p=1");
        }
    } else {
        if($mysqli->real_escape_string($_REQUEST['p']) < 1 or $mysqli->real_escape_string($_REQUEST['p']) > $numbers) {
            $uri = explode("&p=", $_SERVER['REQUEST_URI']);
            $link = $uri[0]."&p=1";

            header("Location: ".$link);
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
    <meta name='description' content='Следите за новосятми компании Аргос-ФМ. Здесь вы найдёте информацию о новых поступлениях и интересных предложениях как для производителей мебели, так и для розничных покупателей.'>

    <title>
        <?php
            if(empty($_REQUEST['id'])) {
                echo "Аргос-ФМ | Новости";
            } else {
                echo "Аргос-ФМ | ".$news['header'];
            }
        ?>
    </title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/style.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />
    <link rel="stylesheet" href="/js/font-awesome-4.7.0/css/font-awesome.min.css">
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='/css/styleOpera.css'>";
		}
	?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="/js/menu.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/news.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<script type='text/javascript' src='/js/indexOpera.js'></script>";
		}
	?>

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

<body id="bodyIndex">

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
                    <a href="/catalogue/index.php?type=fa&p=1" class="menuPoint">Каталог</a>
                    <img src="/img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
                    <a href="/about/info.php">О компании</a>
                    <img src="/img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="/news.php?p=1" style="color: #ff282b;">Новости</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
                    <a href="/stores/company.php">Где купить</a>
                    <img src="/img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
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
				<a href="/news.php?p=1" class="mobileMenuPointBig">Новости</a>
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
					<a href="/partners/news.php?p=1" class="mobileMenuPointSmall">- Новости для клиентов</a>
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
		<h1 style='margin-top: 80px;'>Новости</h1>
		<div id='breadCrumbs'>
			<a href='/'><span class='breadCrumbsText'>Главная</span></a> > <a href='/news.php?p=1'><span class='breadCrumbsText'>Новости</span></a>
		</div>

		<div style="width: 100%; text-align: right;">
			<span style='color: #4c4c4c; font-style: italic; font-size: 16px;'>Архив: </span>
			<?php
                echo "<a href='news.php?p=1'><span style='"; if(empty($_REQUEST['year'])) {echo "color: #ff282b; font-style: italic; font-size: 14px; text-decoration: none;'";} else {echo "color: #4c4c4c; font-style: italic; font-size: 14px; text-decoration: underline;' onmouseover='changeFont(\"allYears\", 1)' onmouseout='changeFont(\"allYears\", 0)'";} echo " class='yearFont' id='allYears'>Все</span></a> ";

				$yearResult = $mysqli->query("SELECT DISTINCT year FROM news ORDER BY year DESC");
				while($year = $yearResult->fetch_array(MYSQLI_NUM)) {
					echo "<a href='/news.php?year=".$year[0]."&p=1'><span style='"; if($_REQUEST['year'] == $year[0]) {echo "color: #ff282b; font-style: italic; font-size: 14px; text-decoration: none;'";} else {echo "color: #4c4c4c; font-style: italic; font-size: 14px; text-decoration: underline;' onmouseover='changeFont(\"year".$year[0]."\", 1)' onmouseout='changeFont(\"year".$year[0]."\", 0)'";} echo " class='yearFont' id='year".$year[0]."'>".$year[0]."</span></a> ";
				}
			?>
		</div>
		<div style="width: 100%; height: 1px; background-color: #c9c9c9; margin-top: 5px;"></div>
		<br />
        <div class="newsContent">
            <?php
                if(empty($_REQUEST['id'])) {
                    if(empty($_REQUEST['year'])) {
                        $newsResult = $mysqli->query("SELECT * FROM news ORDER BY id DESC LIMIT ".$start.", ".NEWS_ON_PAGE);
                    } else {
                        $newsResult = $mysqli->query("SELECT * FROM news WHERE year = '".$_REQUEST['year']."' ORDER BY id DESC LIMIT ".$start.", ".NEWS_ON_PAGE);
                    }

                    while($news = $newsResult->fetch_assoc()) {
                        $month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
                        $index = (int)substr($news['date'], 3, 2) - 1;

                        $date = substr($news['date'], 0, 2)." ".$month[$index]." ".substr($news['date'], 6, 4);

                        echo "
                            <a href='news.php?id=".$news['id']."'>
                                <div class='newsPreview' id='newsPreview".$news['id']."'>
                                    <img src='/img/photos/news/".$news['preview']."' />
                                    <br /><br />
                                    <div style='text-align: left;'>
                                        <span style='color: #ff282b; font-style: italic; font-size: 14px;'>".$date."</span>
                                        <p style='color: #4c4c4c; margin-top: 0;'>".$news['header']."</p>
                                        <div style='text-align: right;'><img src='/img/system/arrow.png' /></div>
                                    </div>
                                </div>
                            </a>
                        ";
                    }
                } else {
                    if($_SESSION['userID'] != 1) {
                        $viewsResult = $mysqli->query("SELECT views FROM news WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                        $views = $viewsResult->fetch_array(MYSQLI_NUM);

                        $views = $views[0] + 1;

                        $mysqli->query("UPDATE news SET views = '".$views."', last_view = '".date("Y-m-d H:i:s")."' WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                    }

                    $newsResult = $mysqli->query("SELECT * FROM news WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                    $news = $newsResult->fetch_assoc();

                    $month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
                    $index = (int)substr($news['date'], 3, 2) - 1;
                    $j = 0;

                    $date = substr($news['date'], 0, 2)." ".$month[$index]." ".substr($news['date'], 6, 4);

                    echo "
                        <div id='personalMenu'>
                            <div id='newsSlider'>
                    ";

                    $yearNewsResult = $mysqli->query("SELECT * FROM news WHERE year = '".$news['year']."' ORDER BY id DESC");
                    while($yearNews = $yearNewsResult->fetch_assoc()) {
                        $j++;
                        $i = (int)substr($yearNews['date'], 3, 2) - 1;
                        $d = substr($yearNews['date'], 0, 2)." ".$month[$i]." ".substr($yearNews['date'], 6, 4);

                        echo "
                            <a href='/news.php?id=".$yearNews['id']."'>
                                <div class='newsPreview' id='newsPreview".$yearNews['id']."' "; if($j > 1) {echo "style='margin-left: 0;";} else {echo "style='margin: 0;";} if($yearNews['id'] == $_REQUEST['id']) {echo " background-color: #ededed;'";} else {echo "'";} echo ">
                                    <img src='/img/photos/news/".$yearNews['preview']."' />
                                    <br /><br />
                                    <div style='text-align: left;'>
                                        <span style='color: #ff282b; font-style: italic; font-size: 14px;'>".$d."</span>
                                        <p style='color: #4c4c4c; margin-top: 0;'>".$yearNews['header']."</p>
                                        <br />
                                        <div style='text-align: right;'><img src='/img/system/arrow.png' /></div>
                                    </div>
                                </div>
                            </a>
                        ";
                    }

                    echo "
                            </div>
                        </div>
    
                        <div id='personalContent'>
                            <span style='color: #ff282b; font-style: italic; font-size: 14px;'>".$date."</span>
                            <br /><br />
                    ";

                    if($_SESSION['userID'] == 1) {
                        echo "
                            <table style='border: 1px dashed #4c4c4c;'>
                                <tr>
                                    <td style='padding: 5px;'>
                                        <span style='font-style: italic; font-size: 14px;'><b>Количетсво просмотров:</b> ".$news['views']."</span>
                                        <br />
                                        <span style='font-style: italic; font-size: 14px;'><b>Последний просмотр:</b> ".$news['last_view']."</span>
                                    </td>
                                </tr>
                            </table>
                            <br />
                        ";
                    }

                    echo "
                            <h2>".$news['header']."</h2>
                            <p>".$news['text']."</p>
                            <a href='/news.php?p=1'><span style='color: #ff282b; font-style: italic; font-size: 14px; text-decoration: underline;' class='yearFont'>Больше новостей</span></a>
                        </div>
                    ";
                }
            ?>

        </div>
        <div class="newsNumbers">
            <?php
                if(empty($_REQUEST['id'])) {
                    echo "<div id='pageNumbers'>";

                    if($numbers > 1) {
                        if(empty($_REQUEST['year'])) {
                            $uri = explode("?p=", $_SERVER['REQUEST_URI']);
                            $link = $uri[0]."?p=";
                        } else {
                            $uri = explode("&p=", $_SERVER['REQUEST_URI']);
                            $link = $uri[0]."&p=";
                        }

                        if($numbers <= 7) {
                            echo "<br /><br />";

                            if($_REQUEST['p'] == 1) {
                                echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
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
                                echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
                            } else {
                                echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
                            }

                            echo "</div>";

                        } else {
                            if($_REQUEST['p'] < 5) {
                                if($_REQUEST['p'] == 1) {
                                    echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
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

                                echo "<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
                                echo "<a href='".$link.$numbers."' class='noBorder'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>";

                                if($_REQUEST['p'] == $numbers) {
                                    echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
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
                                        echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
                                    } else {
                                        echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
                                    }
                                }
                            }
                        }
                    }

                    echo "</div><div style='clear: both;'></div>";
                }
            ?>
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