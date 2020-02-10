<?php

session_start();

include("../scripts/connect.php");
include("../layouts/footer.php");

$id = $mysqli->real_escape_string($_REQUEST['id']);

if(empty($_REQUEST['id'])) {
	header("Location: index.php");
} else {
	$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE id = '".$id."'");
	$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

	if($goodCheck[0] == 0) {
		header("Location: index.php");
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

    $userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
    $user = $userResult->fetch_assoc();
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

$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$id."'");
$good = $goodResult->fetch_assoc();

$typeResult = $mysqli->query("SELECT * FROM types WHERE catalogue_type = '".$good['type']."'");
$type = $typeResult->fetch_assoc();

$goodCategoryResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '".$good['category']."'");
$goodCategory = $goodCategoryResult->fetch_assoc();

if(!empty($good['subcategory'])) {
	$goodSubcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE id = '".$good['subcategory']."'");
	$goodSubcategory = $goodSubcategoryResult->fetch_assoc();
}

if(!empty($good['subcategory2'])) {
	$goodSubcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE id = '".$good['subcategory2']."'");
	$goodSubcategory2 = $goodSubcategory2Result->fetch_assoc();
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="description" content="Здесь вы можете купить «<?= $good['name'] ?>» онлайн. В нашем интернет-магазине более 5.000 видов позиций мебельной фурнитуры, крепежа, кромочных материалов, ручного инструмента и прочих сопутствующих товаров. Бесплатная доставка по Беларуси.">

    <title><?= $good['name'] ?></title>

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
	<script type="text/javascript" src="/js/item.js"></script>
	<script type="text/javascript" src="/js/notify.js"></script>
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
								<input id='searchFieldInput' name='searchField' value='Поиск...' />
							</form>
						</div>
					";
					echo "<div style='clear: both;'></div>";
				?>
			</div>
            <div id="menuLinks">
                <div class="menuLink" id="catalogueLink" <?php echo "onmouseover='showDropdownList(\"1\", \"catalogueLink\", \"catalogueLink".strtoupper($good['type'])."\")'"; ?>>
                    <a href="index.php?type=fa&p=1" class="menuPoint" style="color: #ff282b;">Каталог</a>
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
				<a href="index.php?type=fa&p=1" class="mobileMenuPointBig">Каталог</a>
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
		<div id='searchList'></div>

		<h1 style='margin-top: 80px;'><?= $good['name'] ?></h1>
		<div id='breadCrumbs'>
			<a href='/'><span class='breadCrumbsText'>Главная</span></a> > <a href='index.php'><span class='breadCrumbsText'>Каталог</span></a> > <a href='index.php?type=<?= $good['type'] ?>'><span class='breadCrumbsText'><?= $type['type_name'] ?></span></a> > <a href='index.php?type=<?= $good['type'] ?>&c=<?= $good['category'] ?>'><span class='breadCrumbsText'><?= $goodCategory['name'] ?></span></a><?php if(!empty($good['subcategory'])) {echo " > <a href='index.php?type=".$good['type']."&c=".$good['category']."&s=".$good['subcategory']."'><span class='breadCrumbsText'>".$goodSubcategory['name']."</span></a>";} if(!empty($good['subcategory2'])) {echo " > <a href='index.php?type=".$good['type']."&c=".$good['category']."&s=".$good['subcategory']."&s2=".$good['subcategory2']."'><span class='breadCrumbsText'>".$goodSubcategory2['name']."</span></a>";} ?>
		</div>

		<div id="catalogueMenu">
			<?php
				echo "
					<center><a href='index.php?type=".$type['catalogue_type']."&p=1'><span style='color: #ff282b;'>".$type['type_name']."</span></a></center>
					<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;'></div>
					<div style='margin-top: 10px; width: 100%;'></div>
				";

				$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$type['catalogue_type']."' ORDER BY name");
				while($category = $categoryResult->fetch_assoc()) {
					echo "
						<a href='index.php?type=".$type['catalogue_type']."&c=".$category['id']."&p=1'><div class='categoryContainer'"; if($goodCategory['id'] != $category['id']) {echo " onmouseover='categoryItemStyle(1, \"categoryIMG".$category['id']."\", \"categoryText".$category['id']."\", \"".$category['picture']."\", \"".$category['picture_red']."\")' onmouseout='categoryItemStyle(0, \"categoryIMG".$category['id']."\", \"categoryText".$category['id']."\", \"".$category['picture']."\", \"".$category['picture_red']."\")'";} echo "><img src='/img/icons/"; if($goodCategory['id'] == $category['id']) {echo $category['picture_red'];} else {echo $category['picture'];} echo "' id='categoryIMG".$category['id']."' /><div class='categoryNameContainer'><span id='categoryText".$category['id']."'"; if($goodCategory['id'] == $category['id']) {echo " style='color: #ff282b;'";} echo ">".$category['name']."</span></div></div></a>
					";

					if(!empty($good['subcategory']) and $category['id'] == $goodCategory['id']) {
						$subcategoriesCountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$goodCategory['id']."'");
						$subcategoriesCount = $subcategoriesCountResult->fetch_array(MYSQLI_NUM);

						if($subcategoriesCount[0] > 0) {
							$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$goodCategory['id']."' ORDER BY name");
							while($subcategory = $subcategoryResult->fetch_assoc()) {
								echo "<a href='index.php?type=".$type['catalogue_type']."&c=".$goodCategory['id']."&s=".$subcategory['id']."&p=1'"; if($goodSubcategory['id'] != $subcategory['id']) {echo " onmouseover='subcategoryStyle(1, \"subcategoryText".$subcategory['id']."\")' onmouseout='subcategoryStyle(0, \"subcategoryText".$subcategory['id']."\")'";} echo "><div class='subcategoryContainer'><span id='subcategoryText".$subcategory['id']."'"; if($goodSubcategory['id'] == $subcategory['id']) {echo " style='color: #ff282b;'";} echo ">— ".$subcategory['name']."</span></div></a>";

								if(!empty($good['subcategory2']) and $subcategory['id'] == $goodSubcategory['id']) {
									$subcategories2CountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$goodSubcategory['id']."'");
									$subcategories2Count = $subcategories2CountResult->fetch_array(MYSQLI_NUM);

									if($subcategories2Count[0] > 0) {
										$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$goodSubcategory['id']."' ORDER BY name");
										while($subcategory2 = $subcategory2Result->fetch_assoc()) {
											echo "<a href='index.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$goodSubcategory['id']."&s2=".$subcategory2['id']."&p=1'"; if($goodSubcategory2['id'] != $subcategory2['id']) {echo " onmouseover='subcategoryStyle(1, \"subcategory2Text".$subcategory2['id']."\")' onmouseout='subcategoryStyle(0, \"subcategory2Text".$subcategory2['id']."\")'";} echo "><div class='subcategory2Container'><span id='subcategory2Text".$subcategory2['id']."'"; if($goodSubcategory2['id'] == $subcategory2['id']) {echo " style='color: #ff282b;'";} echo ">— ".$subcategory2['name']."</span></div></a>";
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
						<a href='index.php?type=".$types['catalogue_type']."&p=1' onmouseover='subcategoryStyle(1, \"type".$types['id']."\")' onmouseout='subcategoryStyle(0, \"type".$types['id']."\")'><span id='type".$types['id']."'>".$types['type_name']."</span></a>
					";
				}

				$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
				$unit = $unitResult->fetch_assoc();

				$active = 0;

				$actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$id."'");
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


				$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
				$currency = $currencyResult->fetch_assoc();

				if($active == 0) {
					$price = $good['price'] * $currency['rate'];
					$price_opt = $good['price_opt'] * $currency['rate'];

					if(isset($_SESSION['userID'])) {
						$discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
						$discount = $discountResult->fetch_array(MYSQLI_NUM);

                        if($user['opt'] == 1) {
                            $price = $price_opt;
                        }

						$price = $price * (1 - $discount[0] / 100);
					}
				} else {
					$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$good['id']."' AND action_id = '".$aID."'");
					$actionGood = $actionGoodResult->fetch_assoc();

					$price = $actionGood['price'] * $currency['rate'];
				}

				$roubles = floor($price);
				$kopeck = ceil(($price - $roubles) * 100);

				if($kopeck == 100) {
					$kopeck = 0;
					$roubles ++;
				}

				if($roubles == 0 and $kopeck == 0) {
					$kopeck = 1;
				}

			?>
		</div>
		<div id="catalogueContent">
			<table>
				<tbody>
					<tr>
						<td id="itemPhotoContainer">
							<img src="/img/catalogue/big/<?= $good['picture'] ?>" id="itemPhoto" />
							<?php
								if($active > 0) {
									echo "
										<img src='/img/system/action.png' style='opacity: .6; float: left;' />
										<div style='clear: both;'></div>
									";
								}
							?>
						</td>
						<td id="itemPhotoDescription">
							<?php
								$description = str_replace("\n", "", $good['description']);
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
							?>
							<br />
							<b>Артикул: </b><?= $good['code'] ?>
                            <br />
                            <b>Наличие: </b><?php if($good['quantity'] > 0) {echo "на складе";} else {echo "нет на складе";} ?>
							<br />
							<?php
								echo "
									<div id='goodPrice".$id."'>
										<span"; if($_SESSION['userID'] == 1 and $active == 0) {echo " style='cursor: pointer;' onclick='changePrice(\"".$id."\", \"goodPrice".$id."\", \"".$good['price']."\", \"".$currency['code']."\", \"".$unit['short_name']."\", \"".$currency['rate']."\")' title='Изменить стоимость товара'";} echo "><b>Цена за ".$unit['for_name']; if($discount[0] > 0) {echo " с учётом скидки";} echo ": </b>"; if($good['price'] == 0 or $good['price'] == null) {echo "по запросу";} else {if($active > 0) {echo "<span style='color: #ff282b; font-weight: bold;'>";}echo $roubles." руб. "; $kopeck = ceil($kopeck); if(strlen($kopeck) == 1) {$kopeck = "0".$kopeck;} echo $kopeck." коп.</span>"; if($active > 0) {echo "</span>";}} echo "
									</div>
								";
							?>
						</td>
						<?php
							if(isset($_SESSION['userID']) and $_SESSION['userID'] != 1 and $good['price'] > 0 and $good['quantity'] > 0) {
								echo "
									<td style='width: 65px; vertical-align: top;'>
										<div class='itemPurchase'>
											<span onclick='addToBasket(\"".$id."\", \"quantityInput".$id."\", \"addingResult".$id."\")' class='addToBasketFont'>Добавить в корзину</span>
											<br /><br />
											<form method='post'>
												<label for='quantityInput".$id."'>Кол-во в ".$unit['in_name'].":</label>
												<input type='number' id='quantityInput".$id."' min='1' step='1' value='1' class='itemQuantityInput' />
											</form>
											<br />
											<div class='addingResult' id='addingResult".$id."' onclick='hideBlock(\"addingResult".$id."\")'></div>
										</div>
									</td>
								";
							}

							if($_SESSION['userID'] == 1) {
								echo "
									<td style='width: 50px; vertical-align: top; text-align: center;'>
										<a href='/admin/goods/edit.php?type=".$good['type']."&category=".$good['category']; if(!empty($good['subcategory'])) {echo "&subcategory=".$good['subcategory'];} if(!empty($good['subcategory2'])) {echo "&subcategory2=".$good['subcategory2'];}  echo "&id=".$id."' style='color: #4c4c4c;'><i class='fa fa-pencil' id='editIcon' aria-hidden='true' onmouseover='changeFontColor(\"editIcon\", 1)' onmouseout='changeFontColor(\"editIcon\", 0)' style='cursor: pointer;' title='Редактировать товар'></i></a>
										&nbsp;
										<a href='/admin/goods/delete.php?type=".$good['type']."&category=".$good['category']; if(!empty($good['subcategory'])) {echo "&subcategory=".$good['subcategory'];} if(!empty($good['subcategory2'])) {echo "&subcategory2=".$good['subcategory2'];}  echo "&id=".$id."' style='color: #4c4c4c;'><i class='fa fa-trash' id='deleteIcon' aria-hidden='true' onmouseover='changeFontColor(\"deleteIcon\", 1)' onmouseout='changeFontColor(\"deleteIcon\", 0)' style='cursor: pointer;' title='Удалить товар'></i></a>
									</td>
								";
							}
						?>
					</tr>
				</tbody>
			</table>
			<br />
			<h3>Дополнительные фотографии</h3>
			<div id="previewContainer">
				<a href="/img/catalogue/big/<?= $good['picture'] ?>" class="lightview" data-lightview-options="skin: 'light'" data-lightview-group="item"><img src="/img/catalogue/small/<?= $good['small'] ?>" class="previewPhoto" id="itemMainPhoto" onmouseover='changeItemPhoto("itemMainPhoto", 1)' onmouseout='changeItemPhoto("itemMainPhoto", 0)' /></a>

				<?php
					$photoResult = $mysqli->query("SELECT * FROM goods_photos WHERE good_id = '".$id."'");
					while($photo = $photoResult->fetch_assoc()) {
						echo "
							<div style='width: 20px; display: inline-block;'></div>
							<a href='/img/catalogue/photos/big/".$photo['big']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='item'><img src='/img/catalogue/photos/small/".$photo['small']."' id='itemPhoto".$photo['id']."' class='previewPhoto' onmouseover='changeItemPhoto(\"itemPhoto".$photo['id']."\", 1)' onmouseout='changeItemPhoto(\"itemPhoto".$photo['id']."\", 0)' /></a>
						";
					}

					if(!empty($good['sketch'])) {
						echo "
							<div style='width: 20px; display: inline-block;'></div>
							<a href='/img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='item'><img src='/img/catalogue/sketch/".$good['sketch']."' style='width: 100px;' id='itemSketch' class='previewPhoto' onmouseover='changeItemPhoto(\"itemSketch\", 1)' onmouseout='changeItemPhoto(\"itemSketch\", 0)' /></a>
						";
					}
				?>

			</div>

			<div id="recomendedGoodsBlock">
				<?php
					$items = array();

					if(!empty($good['subcategory2'])) {
						$itemCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory2 = '".$good['subcategory2']."' AND id <> '".$id."'");
						$itemCount = $itemCountResult->fetch_array(MYSQLI_NUM);

						if($itemCount[0] < 5) {
							$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$good['subcategory2']."' AND id <> '".$id."'");
							while($item = $itemResult->fetch_assoc()) {
								array_push($items, $item);
							}

							$quantity = 5 - $itemCount[0];

							$itemCountResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$good['subcategory']."' AND subcategory2 <> '".$good['subcategory2']."'");
							$itemCount = $itemCountResult->fetch_array(MYSQLI_NUM);

							if($itemCount[0] < $quantity) {
								$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$good['subcategory']."' AND subcategory2 <> '".$good['subcategory2']."'");
								while($item = $itemResult->fetch_assoc()) {
									array_push($items, $item);
								}

								$quantity = $quantity - $itemCount[0];

								$itemCountResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$good['category']."' AND id <> '".$id."'");
								$itemCount = $itemCountResult->fetch_array(MYSQLI_NUM);

								if($itemCount[0] < $quantity) {
									$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$good['category']."' AND subcategory <> '".$good['subcategory']."'");
									while($item = $itemResult->fetch_assoc()) {
										array_push($items, $item);
									}
								} else {
									$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$good['category']."' AND subcategory <> '".$good['subcategory']."' ORDER BY RAND() LIMIT ".$quantity);
									while($item = $itemResult->fetch_assoc()) {
										array_push($items, $item);
									}
								}
							} else {
								$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$good['subcategory']."' AND subcategory2 <> '".$good['subcategory2']."' ORDER BY RAND() LIMIT ".$quantity);
								while($item = $itemResult->fetch_assoc()) {
									array_push($items, $item);
								}
							}
						} else {
							$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$good['subcategory2']."' AND id <> '".$id."' ORDER BY RAND() LIMIT 5");
							while($item = $itemResult->fetch_assoc()) {
								array_push($items, $item);
							}
						}
					} else {
						if(!empty($good['subcategory'])) {
							$itemCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory = '".$good['subcategory']."' AND id <> '".$id."'");
							$itemCount = $itemCountResult->fetch_array(MYSQLI_NUM);

							if($itemCount[0] < 5) {
								$quantity = 5 - $itemCount[0];

								$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$good['subcategory']."' AND id <> '".$id."' ORDER BY RAND()");
								while($item = $itemResult->fetch_assoc()) {
									array_push($items, $item);
								}

								$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$good['category']."' AND subcategory <> '".$good['subcategory']."' ORDER BY RAND() LIMIT ".$quantity);
								while($item = $itemResult->fetch_assoc()) {
									array_push($items, $item);
								}
							} else {
								$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$good['subcategory']."' AND id <> '".$id."' ORDER BY RAND() LIMIT 5");
								while($item = $itemResult->fetch_assoc()) {
									array_push($items, $item);
								}
							}
						} else {
							$itemResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$good['category']."' ORDER BY RAND() LIMIT 5");
							while($item = $itemResult->fetch_assoc()) {
								array_push($items, $item);
							}
						}
					}

					if(!empty($items)) {
						echo "
							<br /><br />
							<hr style='opacity: .45;' />
							<br /><br />
							<h3>Похожие товары</h3>
						";

						foreach ($items as $item) {
							$link = "item.php?id=".$item['id'];

							echo "
								<a href='".$link."' style='color: #4c4c4c;' target='_blank'>
									<div class='recomendedGoodContainer' id='goodContainer".$item['id']."' onmouseover='markContainer(\"goodContainer".$item['id']."\", \"goodPhoto".$item['id']."\", 1)' onmouseout='markContainer(\"goodContainer".$item['id']."\", \"goodPhoto".$item['id']."\", 0)'>
										<div class='recomendedGoodPhotoContainer'><img src='/img/catalogue/small/".$item['small']."' id='goodPhoto".$item['id']."' style='transition: .3s;' /></div>
										<br />
										<div class='recomendedGoodNameContainer'>".$item['name']."</div>
										<div style='clear: both;'></div>
									</div>
								</a>
							";
						}
					}
				?>
			</div>
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