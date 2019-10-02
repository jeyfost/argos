<?php

session_start();

include("../scripts/connect.php");
include("../scripts/helpers.php");
include("../layouts/footer.php");

if(!isset($_SESSION['userID'])) {
	header("Location: ../index.php");
}

if(empty($_REQUEST['id'])) {
	if($_SESSION['userID'] == 1) {
		header("Location: ../orders.php?section=1&p=1");
	} else {
		header("Location: ../basket.php?section=1");
	}
} else {
	$id = $mysqli->real_escape_string($_REQUEST['id']);

	$orderCheckResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE id = '".$id."'");
	$orderCheck = $orderCheckResult->fetch_array(MYSQLI_NUM);

	if($orderCheck[0] == 0) {
		if($_SESSION['userID'] == 1) {
			header("Location: ../orders.php?section=1&p=1");
		} else {
			header("Location: ../basket.php?section=1");
		}
	}
}

$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE id = '".$id."'");
$order = $orderResult->fetch_assoc();

if($_SESSION['userID'] != 1) {
	if($order['user_id'] != $_SESSION['userID']) {
		header("Location: ../basket.php?section=1");
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

    <title>Детализация заказа №<?= $order['id'] ?></title>

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
	<script type="text/javascript" src="/js/orders.js"></script>
	<script type="text/javascript" src="/js/order.js"></script>
	<script type="text/javascript" src="/js/notify.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src=/js/lightview/js/spinners/spinners.min.js"></script>
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
				<div class='headerIcon'>
					<?php
						$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
						$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

						if($basketQuantity[0] > 0) {
							echo "
								<div class='headerIcon' id='basketIcon'>
									<a href='orders.php?section=1&p=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")'><img src='/img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
								</div>
							";
						} else {
							echo "
								<div class='headerIcon'>
									<a href='orders.php'><img src='/img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")' /></a>
								</div>
							";
						}
					?>
				</div>
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
                    <a href="/news.php?p=1">Новости</a>
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

		<h1 style='margin-top: 80px;'>Детализация заказа №<?= $order['id'] ?></h1>
		<div id='breadCrumbs'>
			<a href='/'><span class='breadCrumbsText'>Главная</span></a> > <?php if($_SESSION['userID'] == 1) {echo "<a href='basket.php?section=1'><span class='breadCrumbsText'>Заявки</span></a>";} else {echo "<a href='orders.php?section=1&p=1'><span class='breadCrumbsText'>Заявки</span></a>";} ?> > <a href='order.php?id=<?= $order['id'] ?>'><span class='breadCrumbsText'>Детализация заказа №<?= $order['id'] ?></span></a>
		</div>
		<br /><br />
		<b>Статус заявки: </b>
		<?php
			if($order['status'] == 0) {
				echo "Открыта";
			} else {
				echo "Закрыта";
			}

			if($_SESSION['userID'] == 1) {
				$name = "";

				$clientResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
				$client = $clientResult->fetch_assoc();

				if(!empty($client['company'])) {
					$name = $client['company'];
				}

				if(!empty($user['name'])) {
					$name .= " — ".$name;
				}

				echo "
					<br />
					<b>Заказчик: </b>".$name."
				";

				if(!empty($client['phone'])) {
					echo "
						<br />
						<b>Телефон заказчика: </b>".$client['phone']."
					";
				}

				echo "
					<br />
					<b>Email заказчика: </b><a href='email.php?id=".$client['id']."' class='basicLink' target='_blank' title='Написать клиенту' style='font-size: 17px;'>".$client['email']."</a>
				";
			}
		?>
		<br />
		<b>Дата оформления: </b> <?= dateFormattedDayToYear($order['send_date']) ?>
		<?php
			if($order['status'] == 1) {
				echo "
					<br />
					<b>Дата принятия: </b>".dateFormattedDayToYear($order['proceed_date'])."
				";
			}
		?>
		<br /><br /><br />
		<div id="orderBlock">
			<script type="text/javascript">
				<?php
					if($_SESSION['userID'] == 1) {
						if($order['status'] == 0) {
							echo "adminActiveOrder('".$id."');";
						} else {
							echo "adminInactiveOrder('".$id."');";
						}
					} else {
						if($order['status'] == 0) {
							echo "userActiveOrder('".$id."');";
						} else {
							echo "userInactiveOrder('".$id."');";
						}
					}
				?>
			</script>
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