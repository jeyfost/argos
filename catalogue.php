<?php

session_start();
include("scripts/connect.php");
require_once("scripts/mobileDetect.php");

$detect = new Mobile_Detect;

if(empty($_REQUEST['type'])) {
	header("Location: catalogue/index.php?type=fa&p=1");
} else {
	$typeResult = $mysqli->query("SELECT * FROM types WHERE catalogue_type = '".$mysqli->real_escape_string($_REQUEST['type'])."'");

	if($typeResult->num_rows == 0) {
		header("Location: catalogue/index.php?type=fa&p=1");
	}
}

if(empty($_REQUEST['p'])) {
	if(!empty($_REQUEST['type'])) {
		header("Location: ".$_SERVER['REQUEST_URI']."&p=1");
	} else {
		header("Location: catalogue/index.php?type=fa&p=1");
	}
}

if(!empty($_REQUEST['c'])) {
	$cResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['c'])."'");
	if($cResult->num_rows == 0) {
		header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&p=1");
	} else {
		$c = $cResult->fetch_assoc();
		if($c['type'] != $mysqli->real_escape_string($_REQUEST['type'])) {
			header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&p=1");
		}
	}
}

if(!empty($_REQUEST['s']) and empty($_REQUEST['c'])) {
	header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&p=1");
}

if(!empty($_REQUEST['s'])) {
	$sResult = $mysqli->query("SELECT * FROM subcategories_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['s'])."'");
	if($sResult->num_rows == 0) {
		header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&p=1");
	} else {
		$s = $sResult->fetch_assoc();
		if($s['category'] != $mysqli->real_escape_string($_REQUEST['c'])) {
			header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&p=1");
		}
	}
}

if(!empty($_REQUEST['s2']) and empty($_REQUEST['s'])) {
	header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&s=".$mysqli->real_escape_string($_REQUEST['s'])."&p=1");
}

if(!empty($_REQUEST['s2'])) {
	$s2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE id = '".$mysqli->real_escape_string($_REQUEST['s2'])."'");
	if($s2Result->num_rows == 0) {
		header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&s=".$mysqli->real_escape_string($_REQUEST['s'])."&p=1");
	} else {
		$s2 = $s2Result->fetch_assoc();
		if($s2['subcategory'] != $mysqli->real_escape_string($_REQUEST['s'])) {
			header("Location: catalogue/index.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&s=".$mysqli->real_escape_string($_REQUEST['s'])."&p=1");
		}
	}
}

if(!empty($_REQUEST['s2'])) {
	$catalogueCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory2 = '".$mysqli->real_escape_string($_REQUEST['s2'])."'");
} else {
	if(!empty($_REQUEST['s'])) {
		$catalogueCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory = '".$mysqli->real_escape_string($_REQUEST['s'])."'");
	} else {
		if(!empty($_REQUEST['c'])) {
			$catalogueCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE category = '".$mysqli->real_escape_string($_REQUEST['c'])."'");
		} else {
			if(!empty($_REQUEST['type'])) {
				$catalogueCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE type = '".$mysqli->real_escape_string($_REQUEST['type'])."'");
			}
		}
	}
}

$quantity = $catalogueCountResult->fetch_array(MYSQLI_NUM);

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

if($mysqli->real_escape_string($_REQUEST['p']) < 1 or $mysqli->real_escape_string($_REQUEST['p']) > $numbers) {
	$uri = explode("&p=", $_SERVER['REQUEST_URI']);
	$link = $uri[0]."&p=1";

	header("Location: ".$link);
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

    <title>Аргос-ФМ | Каталог</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/style.css'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/media.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />
    <link rel="stylesheet" href="/js/font-awesome-4.7.0/css/font-awesome.min.css">
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='/css/styleOpera.css'>";
		}
	?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/menu.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/catalogue.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>

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
							<form method='post'>
								<input type='text' id='searchFieldInput' name='searchField' value='Поиск...' />
							</form>
						</div>
					";
					echo "<div style='clear: both;'></div>";
				?>
			</div>
            <div id="menuLinks">
                <div class="menuLink" id="catalogueLink" <?php echo "onmouseover='showDropdownList(\"1\", \"catalogueLink\", \"catalogueLink".strtoupper($mysqli->real_escape_string($_REQUEST['type']))."\")'"; ?>>
                    <a href="/catalogue/index.php?type=fa&p=1" class="menuPoint" style="color: #ff282b;">Каталог</a>
                    <img src="/img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
                    <a href="/about/info.php">О компании</a>
                    <img src="/img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="/news.php">Новости</a>
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
        <div id="menuIcon" onclick="showHideMobileMenu()"><img src="/img/system/mobile/menuIcon.png" title="Меню" <?php if($detect->isMobile()) {echo "style='display: block;'";} ?> /></div>
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
            <img src="/img/system/dropDownListArrow.png" id="dropDownArrow" />
        </div>
        <div id="dropDownList"></div>
    </div>
    <div id="menuShadow"></div>

	<div id="page">
		<div id='searchList'></div>
		<?php
			$type = $typeResult->fetch_assoc();
			echo "
				<h1 style='margin-top: 80px;'>".$type['type_name']."</h1>
				<div id='breadCrumbs'>
				<a href='/'><span class='breadCrumbsText'>Главная</span></a> > <a href='/catalogue/index.php?type=fa&p=1'><span class='breadCrumbsText'>Каталог</span></a> > <a href='/catalogue/index.php?type=".$type['catalogue_type']."&p=1'><span class='breadCrumbsText'>".$type['type_name']."</span></a>
			";

			if(!empty($_REQUEST['c'])) {
				$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '" . $mysqli->real_escape_string($_REQUEST['c']) . "'");
				$category = $categoryResult->fetch_assoc();

				echo " > <a href='/catalogue/index.php?type=" . $type['catalogue_type'] . "&c=" . $category['id'] . "&p=1'><span class='breadCrumbsText'>" . $category['name'] . "</span></a>";
			}

			if(!empty($_REQUEST['s'])) {
				$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['s'])."'");
				$subcategory = $subcategoryResult->fetch_assoc();

				echo " > <a href='/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&p=1'><span class='breadCrumbsText'>".$subcategory['name']."</span></a>";
			}

			if(!empty($_REQUEST['s2'])) {
				$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE id = '".$mysqli->real_escape_string($_REQUEST['s2'])."'");
				$subcategory2 = $subcategory2Result->fetch_assoc();

				echo " > <a href='/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&s2=".$subcategory2['id']."&p=1'><span class='breadCrumbsText'>".$subcategory2['name']."</span></a>";
			}

			echo "
			</div>
			";
		?>
		<div id="catalogueMenu">
			<?php
				echo "
					<center><a href='/catalogue/index.php?type=".$type['catalogue_type']."&p=1'><span style='color: #ff282b;'>".$type['type_name']."</span></a></center>
					<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;'></div>
					<div style='margin-top: 10px; width: 100%;'></div>
				";

				$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$type['catalogue_type']."' ORDER BY name");
				while($category = $categoryResult->fetch_assoc()) {
					echo "
						<a href='/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&p=1'><div class='categoryContainer'"; if($_REQUEST['c'] != $category['id']) {echo " onmouseover='categoryStyle(1, \"categoryIMG".$category['id']."\", \"categoryText".$category['id']."\", \"".$category['picture']."\", \"".$category['picture_red']."\")' onmouseout='categoryStyle(0, \"categoryIMG".$category['id']."\", \"categoryText".$category['id']."\", \"".$category['picture']."\", \"".$category['picture_red']."\")'";} echo "><img src='img/icons/"; if($_REQUEST['c'] == $category['id']) {echo $category['picture_red'];} else {echo $category['picture'];} echo "' id='categoryIMG".$category['id']."' /><div class='categoryNameContainer'><span id='categoryText".$category['id']."'"; if($_REQUEST['c'] == $category['id']) {echo " style='color: #ff282b;'";} echo ">".$category['name']."</span></div></div></a>
					";

					if(!empty($_REQUEST['c']) and $category['id'] == $_REQUEST['c']) {
						$subcategoriesCountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$category['id']."'");
						$subcategoriesCount = $subcategoriesCountResult->fetch_array(MYSQLI_NUM);

						if($subcategoriesCount[0] > 0) {
							$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$mysqli->real_escape_string($_REQUEST['c'])."' ORDER BY name");
							while($subcategory = $subcategoryResult->fetch_assoc()) {
								echo "<a href='/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&p=1'"; if($_REQUEST['s'] != $subcategory['id']) {echo " onmouseover='subcategoryStyle(1, \"subcategoryText".$subcategory['id']."\")' onmouseout='subcategoryStyle(0, \"subcategoryText".$subcategory['id']."\")'";} echo "><div class='subcategoryContainer'><span id='subcategoryText".$subcategory['id']."'"; if($_REQUEST['s'] == $subcategory['id']) {echo " style='color: #ff282b;'";} echo ">— ".$subcategory['name']."</span></div></a>";

								if(!empty($_REQUEST['s']) and $subcategory['id'] == $_REQUEST['s']) {
									$subcategories2CountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
									$subcategories2Count = $subcategories2CountResult->fetch_array(MYSQLI_NUM);

									if($subcategories2Count[0] > 0) {
										$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$subcategory['id']."' ORDER BY name");
										while($subcategory2 = $subcategory2Result->fetch_assoc()) {
											echo "<a href='/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&s2=".$subcategory2['id']."&p=1'"; if($_REQUEST['s2'] != $subcategory2['id']) {echo " onmouseover='subcategoryStyle(1, \"subcategory2Text".$subcategory2['id']."\")' onmouseout='subcategoryStyle(0, \"subcategory2Text".$subcategory2['id']."\")'";} echo "><div class='subcategory2Container'><span id='subcategory2Text".$subcategory2['id']."'"; if($_REQUEST['s2'] == $subcategory2['id']) {echo " style='color: #ff282b;'";} echo ">— ".$subcategory2['name']."</span></div></a>";
										}
										echo "<div style='width: 100%; height: 5px;'></div>";
									}
								}
							}
							echo "<div style='width: 100%; height: 5px;'></div>";
						}
					}
				}

				$typesResult = $mysqli->query("SELECT * FROM types WHERE id <> '".$type['id']."' ORDER BY id");
				while($types = $typesResult->fetch_assoc()) {
					echo "
						<div style='margin-top: 10px; width: 100%;'></div>
						<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;'></div>
						<div style='margin-top: 10px; width: 100%;'></div>
						<a href='/catalogue/index.php?type=".$types['catalogue_type']."&p=1' onmouseover='subcategoryStyle(1, \"type".$types['id']."\")' onmouseout='subcategoryStyle(0, \"type".$types['id']."\")'><span id='type".$types['id']."'>".$types['type_name']."</span></a>
					";
				}
			?>
		</div>
		<div id="catalogueContent">
			<?php
			if(!empty($_REQUEST['s2'])) {
				$catalogueResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$mysqli->real_escape_string($_REQUEST['s2'])."' ORDER BY name LIMIT ".$start.", 10");

			} else {
				if(!empty($_REQUEST['s'])) {
					$catalogueResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$mysqli->real_escape_string($_REQUEST['s'])."' ORDER BY name LIMIT ".$start.", 10");
				} else {
					if(!empty($_REQUEST['c'])) {
						$catalogueResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$mysqli->real_escape_string($_REQUEST['c'])."' ORDER BY name LIMIT ".$start.", 10");
					} else {
						$catalogueResult = $mysqli->query("SELECT * FROM catalogue_new WHERE type = '".$mysqli->real_escape_string($_REQUEST['type'])."' ORDER BY name LIMIT ".$start.", 10");
					}
				}
			}

			if($quantity[0] > 0) {
				echo "<span style='font-size: 15px;'>Показаны товары <b>".($mysqli->real_escape_string($_REQUEST['p']) * 10 - 9)." - "; if($_REQUEST['p'] == $numbers) {echo $quantity[0];} else {echo ($mysqli->real_escape_string($_REQUEST['p']) * 10 );} echo "</b> из <b>".$quantity[0]."</b></span><br /><br />";
			} else {
				echo "<span style='font-size: 15px;'><b>К сожалению, на данный момент в этом разделе нет товаров. Приносим свои извинения за доставленные неудобства.</b></span>";
			}

			while($catalogue = $catalogueResult->fetch_array()) {
				$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$catalogue['unit']."'");
				$unit = $unitResult->fetch_assoc();

				$active = 0;

				$actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$catalogue['id']."'");
				if($actionIDResult->num_rows > 0) {
					while($actionID = $actionIDResult->fetch_assoc()) {
						$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID['action_id']."'");
						$action = $actionResult->fetch_assoc();
						$from = strtotime($action['from_date']);
						$to = strtotime($action['to_date']);
						$today = strtotime(date('d-m-Y'));

						if($today >= $from and $today <= $to) {
							$active = 1;
							$aID = $action['id'];
						}
					}
				}

				$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$catalogue['currency']."'");
				$currency = $currencyResult->fetch_assoc();

				if($active == 0) {
					$price = $catalogue['price'] * $currency['rate'];

					if(isset($_SESSION['userID'])) {
						$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
						$discount = $discountResult->fetch_array(MYSQLI_NUM);

						$price = $price * (1 - $discount[0] / 100);
					}
				} else {
					$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$catalogue['id']."' AND action_id = '".$aID."'");
					$actionGood = $actionGoodResult->fetch_assoc();

					$price = $actionGood['price'] * $currency['rate'];
				}

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
							<table style='border: none; width: 100%;'>
								<tr>
									<td style='width: 100px;' valign='top'>
										<div class='catalogueIMG'>
											<a href='/img/catalogue/big/".$catalogue['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$catalogue['name']."' data-lightview-caption='".nl2br(strip_tags($catalogue['description']))."'><img src='/img/catalogue/small/".$catalogue['small']."' /></a>
							";

							if($active > 0) {
								echo "<img src='/img/system/action.png' class='actionIMG' />";
							}

							echo "
										</div>
									</td>
									<td>
										<div class='catalogueInfo'>
												<div class='catalogueName'>
													<div style='width: 5px; height: 30px; background-color: #ff282b; position: relative; float: left;'></div>
													<div style='margin-left: 15px;'><a href='/catalogue/item.php?id=".$catalogue['id']."' class='catalogueNameLink'>".$catalogue['name']."</a></div>
													<div style='clear: both;'></div>
												</div>
												<div class='catalogueDescription'>
													<table style='width: 100%;'>
														<tbody>
															<tr>
																<td>
							";

							$description = str_replace("\n", "", $catalogue['description']);
							$strings = explode("<br />", $description);

							for($i = 0; $i < count($strings); $i++) {
								$string = explode(':', $strings[$i]);
								if(count($string) > 1) {
									for($j = 0; $j < count($string); $j++) {
										if($j == 0) {
											echo "<b>".$string[$j].":</b>";
										} else {
											if($j == (count($string) - 1)) {
												echo $string[$j];
											} else {
												echo $string[$j].":";
											}
										}
									}
									echo "<br />";
								} else {
									echo $string[0]."<br />";
								}
							}

							echo "
								<br />
								<div style='width: 100%; border-bottom: 1px dotted #d4d4d4;'></div>
								<br />
								<b>Артикул: </b>".$catalogue['code']."
								<br />
								<div id='goodPrice".$catalogue['id']."'>
									<span"; if($_SESSION['userID'] == 1 and $active == 0) {echo " style='cursor: pointer;' onclick='changePrice(\"".$catalogue['id']."\", \"goodPrice".$catalogue['id']."\", \"".$catalogue['price']."\", \"".$currency['code']."\", \"".$unit['short_name']."\", \"".$currency['rate']."\")' title='Изменить стоимость товара'";} echo "><b>Цена за ".$unit['for_name'].": </b>"; if($catalogue['price'] == 0 or $catalogue['price'] == null) {echo "по запросу";} else {if($active > 0) {echo "<span style='color: #ff282b; font-weight: bold;'>";} if($roubles > 0) {echo $roubles." руб. ";} echo ceil($kopeck)." коп.</span>"; if($active > 0) {echo "</span>";}} echo "
								</div>
							";

							if($catalogue['sketch'] != '') {
								echo "<br /><a href='/img/catalogue/sketch/".$catalogue['sketch']."' data-lightview-title='".$catalogue['name'].": Чертёж' data-lightview-options='skin: \"light\"' class='lightview'><span class='sketchFont'>Чертёж</span></a>";
							}

							echo "
								</td>
								<td style='width: 65px; vertical-align: top;'>
							";

							if(isset($_SESSION['userID']) and $_SESSION['userID'] != 1) {
								echo "
									<div class='itemPurchase'>
										<img src='/img/system/toBasket.png' id='toBasketIMG".$catalogue['id']."' class='toBasketIMG' onmouseover='changeIcon(\"toBasketIMG".$catalogue['id']."\", \"toBasketRed.png\")' onmouseout='changeIcon(\"toBasketIMG".$catalogue['id']."\", \"toBasket.png\")' title='Добавить в корзину' onclick='addToBasket(\"".$catalogue['id']."\", \"quantityInput".$catalogue['id']."\", \"addingResult".$catalogue['id']."\")' />
										<form method='post'>
											<label for='quantityInput".$catalogue['id']."'>Кол-во в ".$unit['in_name'].":</label>
											<input type='number' id='quantityInput".$catalogue['id']."' min='1' step='1' value='1' class='itemQuantityInput' />
										</form>
										<br />
										<div class='addingResult' id='addingResult".$catalogue['id']."' onclick='hideBlock(\"addingResult".$catalogue['id']."\")'></div>
									</div>
			
								";
							}

							echo "
																</td>
															</tr>	
														</tbody>
													</table>	
											</div>
										</div>
									</td>
								</tr>
							</table>
						<div style='clear: both;'></div>
					</div>
				";

				echo "
						<div style='clear: both;'></div>
					</div>
					<div style='width: 100%; height: 20px;'></div>
					<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;'></div>
					<div style='width: 100%; height: 20px;'></div>
				";
			}

			echo "<div id='pageNumbers'>";

			if($numbers > 1) {
				$uri = explode("&p=", $_SERVER['REQUEST_URI']);
				$link = $uri[0]."&p=";
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

			?>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div style="clear: both;"></div>
	<div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="/contacts/main.php">Контактная информация</a> | <a href="/sitemap.php">Карта сайта</a></div>
            <div class="copy" style="float: right;"><i class="fa fa-phone" aria-hidden="true"></i> +375 (222) 747-800<br /><i class="fa fa-phone" aria-hidden="true"></i> +375 (222) 707-707</div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>