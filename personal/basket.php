<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../index.php");
} else {
	if($_SESSION['userID'] == 1) {
		header("Location: orders.php");
	}
}

if(empty($_REQUEST['section'])) {
	header("Location: basket.php?section=1");
} else {
	if($_REQUEST['section'] != 1 and $_REQUEST['section'] != 2 and $_REQUEST['section'] != 3) {
		header("Location: basket.php?section=1");
	}
}

include("../scripts/connect.php");
include("../scripts/helpers.php");

if($_REQUEST['section'] == 3) {
	if(empty($_REQUEST['p'])) {
		header("Location: basket.php?section=3&p=1");
	} else {
		$quantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '1'");
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

		if($_REQUEST['p'] < 1) {
			header("Location: orders.php?section=2&p=1");
		}

		if($_REQUEST['p'] > $numbers) {
			header("Location: orders.php?section=2&p=".$numbers);
		}

		$page = $mysqli->real_escape_string($_REQUEST['p']);
		$start = $page * 10 - 10;
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

    <title><?php if($_REQUEST['section'] == 1) {echo "Корзина";} if($_REQUEST['section'] == 2) {echo "Активные заявки";} if($_REQUEST['section'] == 3) {echo "История заказов";} ?></title>

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
    <script type="text/javascript" src="/js/menu1.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/basket.js"></script>
	<script type="text/javascript" src="/js/notify.js"></script>
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
				<div class='headerIcon'>
					<a href='/scripts/personal/logout.php'><img src='/img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon("exitIMG", "exitRed.png")' onmouseout='changeIcon("exitIMG", "exit.png")' /></a>
				</div>
				<div class='headerIcon'>
					<a href='/personal/personal.php?section=1'><img src='/img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon("personalIMG", "personalRed.png")' onmouseout='changeIcon("personalIMG", "personal.png")' /></a>
				</div>
				<?php
					if($_SESSION['userID'] == 1) {
						echo "
							<div class='headerIcon'>
								<a href='orders.php'><img src='/img/system/basketFullRed.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFull.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFullRed.png\")' /></a>
							</div>
						";
					} else {
						$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
						$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

						if($basketQuantity[0] > 0) {
							echo "
								<div class='headerIcon' id='basketIcon'>
									<a href='basket.php' onmouseover='changeIcon(\"basketIMG\", \"basketFull.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFullRed.png\")'><img src='/img/system/basketFullRed.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
								</div>
								";
						} else {
							echo "
								<div class='headerIcon' id='basketIcon'>
									<a href='basket.php?section=1'><img src='/img/system/basketFullRed.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFull.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFullRed.png\")' /></a>
								</div>
							";
						}
					}
				?>
				<div id='searchBlock'>
					<form method='post'>
						<input type='text' id='searchFieldInput' name='searchField' value='Поиск...' />
					</form>
				</div>
				<div style="clear: both;"></div>
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
		<div id="searchList"></div>
		<h1 style='margin-top: 80px;'><?php if($_REQUEST['section'] == 1) {echo "Корзина";} if($_REQUEST['section'] == 2) {echo "Активные заявки";} if($_REQUEST['section'] == 3) {echo "История заказов";} ?></h1>
		<div id='breadCrumbs'>
			<a href='/'><span class='breadCrumbsText'>Главная</span></a> > <?php if($_SESSION['userID'] == 1) {echo "<a href='basket.php?section=1'><span class='breadCrumbsText'>Оформление онлайн-заявок</span></a>";} else {echo "<a href='basket.php?section=1'><span class='breadCrumbsText'>Заказы</span></a> >";} ?>
			<?php
				switch($_REQUEST['section']) {
					case 1:
						echo "<a href='basket.php?section=1'><span class='breadCrumbsText'>Корзина</span></a>";
						break;
					case 2:
						echo "<a href='basket.php?section=2'><span class='breadCrumbsText'>Активные заявки</span></a>";
						break;
					case 3:
						echo "<a href='basket.php?section=3&p=1'><span class='breadCrumbsText'>История заказов</span></a>";
						break;
					default: break;
				}
			?>
		</div>

		<?php
			echo "
				<div id='personalMenu'>
					<a href='basket.php?section=1'><div "; if($_REQUEST['section'] == 1) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pbb1' onmouseover='buttonChange(\"pbb1\", 1)' onmouseout='buttonChange(\"pbb1\", 0)'";} echo ">Корзина</div></a>
					<div style='width: 100%; height: 5px;'></div>
					<a href='basket.php?section=2'><div "; if($_REQUEST['section'] == 2) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pbb2' onmouseover='buttonChange(\"pbb2\", 1)' onmouseout='buttonChange(\"pbb2\", 0)'";} echo ">Активные заявки</div></a>
					<div style='width: 100%; height: 5px;'></div>
					<a href='basket.php?section=3&p=1'><div "; if($_REQUEST['section'] == 3) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pbb3' onmouseover='buttonChange(\"pbb3\", 1)' onmouseout='buttonChange(\"pbb3\", 0)'";} echo ">История заказов</div></a>
				</div>
				<div id='personalContent'>
					<div id='goodResponseField'></div>
			";

			$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
			$user = $userResult->fetch_assoc();

			switch($_REQUEST['section']) {
				case 1:
					if($basketQuantity[0] == 0) {
						echo "<span style='font-size: 15px;'><b>На данный момент ваша корзина пуста. Чтобы в ней появились товары, добавьте их <a href='/catalogue/index.php?type=fa&p=1' style='color: #df4e47;'>из каталога</a></b>.</span>";
					} else {
						echo "<span style='font-size: 15px;'>Всего групп товаров в коризне: <b id='basketQuantityText'>".$basketQuantity[0]."</b></span><br /><br />";
						$totalNormal = 0;
						$totalAction = 0;
						$aID = 0;
						$actionGoodsQuantity = 0;

						$basketResult = $mysqli->query("SELECT * FROM basket WHERE user_id = '".$_SESSION['userID']."' ORDER BY id");
						while($basket = $basketResult->fetch_assoc()) {
							$active = 0;

							$actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$basket['good_id']."'");
							if($actionIDResult->num_rows > 0) {
								while($actionID = $actionIDResult->fetch_assoc()) {
									$actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID['action_id']."'");
									$action = $actionResult->fetch_assoc();

									$dx = (int)date('d');
									$mx = (int)date('m');
									$yx = (int)date('Y');

									$d1 = (int)substr($action['from_date'], 0, 2);
									$m1 = (int)substr($action['from_date'], 3, 2);
									$y1 = (int)substr($action['from_date'], 6, 4);

									$d2 = (int)substr($action['to_date'], 0, 2);
									$m2 = (int)substr($action['to_date'], 3, 2);
									$y2 = (int)substr($action['to_date'], 6, 4);

									if($y1 < $yx and $yx < $y2) {
										$active++;
									}

									if($y1 < $yx and $yx == $y2) {
										if($mx < $m2) {
											$active++;
										}

										if($mx == $m2 and $dx <= $d2) {
											$active++;
										}
									}

									if($y1 == $yx) {
										if($m1 < $mx) {
											if($yx < $y2) {
												$active++;
											}

											if($yx == $y2) {
												if($mx < $m2) {
													$active++;
												}

												if($mx == $m2 and $dx <= $d2) {
													$active++;
												}
											}
										}

										if($m1 == $mx and $d1 <= $dx) {
											if($yx < $y2) {
												$active++;
											}

											if($yx == $y2) {
												if($mx < $m2) {
													$active++;
												}

												if($mx == $m2 and $dx <= $d2) {
													$active++;
												}
											}
										}
									}

									if($active > 0) {
										$aID = $actionID['action_id'];
										$actionGoodsQuantity++;
									}
								}
							}

							$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$basket['good_id']."'");
							$good = $goodResult->fetch_assoc();

							$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
							$unit = $unitResult->fetch_assoc();

							$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
							$currency = $currencyResult->fetch_assoc();

							if($active == 0) {
								$price = $good['price'] * $currency['rate'];
								$totalNormal += $price * $basket['quantity'];
								$price = $price * (1 - $user['discount'] / 100);
							} else {
								$actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$basket['good_id']."' AND action_id = '".$aID."'");
								$actionGood = $actionGoodResult->fetch_assoc();

								$price = $actionGood['price'] * $currency['rate'];
								$totalAction += $price * $basket['quantity'];
							}

							$roubles = floor($price);
							$kopeck = round(($price - $roubles) * 100);
							if($kopeck == 100) {
								$kopeck = 0;
								$roubles ++;
							}

							echo "
								<div class='catalogueItem' id='ci".$good['id']."'>
									<div class='itemDescription'>
									<table style='border: none; width: 100%;'>
										<tr>
											<td style='width: 100px;' valign='top'>
												<div class='catalogueIMG'>
													<a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
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
													<div style='width: 5px; height: 30px; background-color: #df4e47; position: relative; float: left;'></div>
													<div style='margin-left: 15px;'><a href='/catalogue/item.php?id=".$good['id']."' class='catalogueNameLink'>".$good['name']."</a></div>
													<div style='clear: both;'></div>
												</div>
												<div class='catalogueDescription'>
								";
								$strings = explode("<br />", $good['description']);
								for($i = 0; $i < count($strings); $i++) {
									$string = explode(':', $strings[$i]);
									if(count($string) > 1) {
										echo "<b>".$string[0].":</b>".$string[1]."<br />";
									} else {
										echo $string[0]."<br />";
									}
								}
								echo "
									<br />
									<b>Артикул: </b>".$good['code']."
									<br />
									<div id='goodPrice".$good['id']."'>
										<span><b>Стоимость за ".$unit['short_name'].": </b>"; if($active > 0) {echo "<span style='color: #df4e47; font-weight: bold;'>";} if($roubles > 0) {echo $roubles." руб. ";} echo $kopeck." коп.</span>"; if($active > 0) {echo "</span>";} echo "
								";

								if($good['sketch'] != '') {
									echo "<br /><br /><a href='/img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
								}

								echo "
													</div>
												</div>
											</div>
										</td>
										<td style='width: 65px; vertical-align: top;'>
											<div class='itemPurchase'>
												<img src='/img/system/delete.png' id='deleteIMG".$good['id']."' style='cursor: pointer; float: right;' title='Убрать товар из корзины' onmouseover='changeIcon(\"deleteIMG".$good['id']."\", \"deleteRed.png\", 1)' onmouseout='changeIcon(\"deleteIMG".$good['id']."\", \"delete.png\", 1)' onclick='removeGood(\"".$good['id']."\")' />
												<br /><br />
												<form method='post'>
													<label for='quantityInput".$good['id']."'>Кол-во в ".$unit['in_name'].":</label>
													<input type='number' id='quantityInput".$good['id']."' min='1' step='1' value='".$basket['quantity']."' class='itemQuantityInput' onkeyup='changeQuantity(\"".$good['id']."\")' onchange='changeQuantity(\"".$good['id']."\")' />
												</form>
												<br />
												<div class='addingResult' id='addingResult".$good['id']."' onclick='hideBlock(\"addingResult".$good['id']."\")'></div>
											</div>
										</td>
										</tr>
										</table>
									</div>
									<div style='clear: both;'></div>
								</div>
								<div style='width: 100%; height: 20px;' id='cis".$good['id']."'></div>
								<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;' id='cil".$good['id']."'></div>
								<div style='width: 100%; height: 20px;'></div>
							";
						}

						$total = $totalAction + $totalNormal * (1 - $user['discount'] / 100);
						$roubles = floor($total);
						$kopeck = round(($total - $roubles) * 100);
						if($kopeck == 100) {
							$kopeck = 0;
							$roubles++;
						}

						if($roubles == 0) {
							$total = $kopeck." коп.";
						} else {
							$total = $roubles." руб. ".$kopeck." коп.";
						}

						echo "
							<br /><br />
							<div style='float: right;'><b>Ваша личная скидка: </b><span>".$user['discount']."%</span></div>
							<br />
						";

						if($actionGoodsQuantity > 0) {
							echo "<span style='float: right; font-size: 14px; color: #df4e47;'>Ваша личная скидка не действует на акционные товары.</span><br /><br />";
						}

						echo "
							<div style='float: right;'><b>Общая стоимость: </b><span id='totalPriceText'>".$total."</span></div>
							<br /><br />
							<div id='responseField'></div>
							<form method='post'>
								<input type='button' value='Оформить заказ' id='basketSubmit' onmouseover='buttonChange(\"basketSubmit\", 1)' onmouseout='buttonChange(\"basketSubmit\", 0)' onclick='sendOrder()' />
								<input type='button' value='Очистить корзину' id='clearBasketButton' onmouseover='buttonChange(\"clearBasketButton\", 1)' onmouseout='buttonChange(\"clearBasketButton\", 0)' onclick='clearBasket()' />
							</form>
						";
					}
					break;
				case 2:
					$ordersQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '0'");
					$ordersQuantity = $ordersQuantityResult->fetch_array(MYSQLI_NUM);

					if($ordersQuantity[0] == 0) {
						echo "<span style='font-size: 15px;'><b>На данный момент у вас нет активных заявок.</b></span>";
					} else {
						$j = 0;
						$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '0'");
						echo "
							<p>Активные заявки — это заказы, которые ещё не обработаны менеджером. До момента принятия заказа вы вправе редактировать свои заказы. Для этого нажмите на соответствующий номер заказа, выделенный красным цветом.</p>
						";

						if($ordersQuantity[0] > 1) {
						    echo "
                                <div id='orderSearchList'></div>
						        <form method='post'>
						            <input id='orderSearchInput' placeholder='Номер заказа...' />
						        </form>
						        <br />
						    ";
                        }

						echo "
							<table style='width: 100%; text-align: center;'>
								<tr class='headTR'>
									<td>№</td>
									<td>Заказ</td>
									<td style='cursor: default;'><i class='fa fa-folder-open-o' aria-hidden='true'></i></td>
									<td>Дата оформления</td>
									<td>Отмена заказа</td>
								</tr>
						";
						while($order = $orderResult->fetch_assoc()) {
							$j++;
							echo "
								<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
									<td>".$j."</td>
									<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
									<td><a href='order.php?id=".$order['id']."' target='_blank' class='font-awesome-link' title='Открыть детализацию заказа в новом окне'><i class='fa fa-folder-open-o' aria-hidden='true'></i></a></td>
									<td>".dateFormattedDayToYear($order['send_date'])."</td>
									<td><span class='tdLink' onclick='cancelOrder(\"".$order['id']."\")'>Отменить заказ</span></td>
								</tr>
							";
						}
						echo "
							</table>
							<br /><br />
							<div id='responseField'></div>
						";
					}
					break;
				case 3:
					$j = 0;

					echo "
						<table style='min-width: 100%; text-align: center;' id='ordersTable'>
							<tr class='headTR'>
								<td>№</td>
								<td>Заказ</td>
								<td style='cursor: default;'><i class='fa fa-folder-open-o' aria-hidden='true'></i></td>
								<td>Дата оформления</td>
								<td>Дата принятия</td>
							</tr>
					";
					$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '1' ORDER BY id DESC LIMIT ".$start.", 10");
					while($order = $orderResult->fetch_assoc()) {
						$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
						$user = $userResult->fetch_assoc();
						$j++;

						echo "
							<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
								<td>".($page * 10 - 10 + $j)."</td>
								<td><span class='tdLink' onclick='showOrderDetailsHistory(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
								<td><a href='order.php?id=".$order['id']."' target='_blank' class='font-awesome-link' title='Открыть детализацию заказа в новом окне'><i class='fa fa-folder-open-o' aria-hidden='true'></i></a></td>
								<td>".dateFormattedDayToYear($order['send_date'])."</td>
								<td>".dateFormattedDayToYear($order['proceed_date'])."</td>
							</tr>
						";
					}

					$summ = 0;
					$ordersResult = $mysqli->query("SELECT * FROM orders_info WHERE user_id = '".$_SESSION['userID']."' AND status = '1'");

					while($orders = $ordersResult->fetch_assoc()) {
					    $summ += $orders['summ'];
                    }

					echo "
						</table>
						<br /><br />
					";

					if($summ > 0) {
					    $r = floor($summ);
					    $k = round(($summ - $r) * 100);

					    if($r > 0) {
					        $summ = $r." руб. ".$k." коп.";
                        } else {
					        $summ = $k." коп.";
                        }

					    echo "<span><b>Общая сумма покупок:</b> ".$summ."</span>";
                    }

					echo "
						<div id='pageNumbers'>
					";

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
					echo "<br /><br /><div id='responseField'></div>";
					break;
				default: break;
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
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="/contacts/main.php">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="https://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>