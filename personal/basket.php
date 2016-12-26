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

    <title><?php if($_REQUEST['section'] == 1) {echo "Корзина";} if($_REQUEST['section'] == 2) {echo "Активные заявки";} if($_REQUEST['section'] == 3) {echo "история заказов";} ?></title>

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
	<script type="text/javascript" src="../js/basket.js"></script>
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
				<div class='headerIcon'>
					<a href='../scripts/personal/logout.php'><img src='../img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon("exitIMG", "exitRed.png", 1)' onmouseout='changeIcon("exitIMG", "exit.png", 1)' /></a>
				</div>
				<div class='headerIcon'>
					<a href='../personal/personal.php?section=1'><img src='../img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon("personalIMG", "personalRed.png", 1)' onmouseout='changeIcon("personalIMG", "personal.png", 1)' /></a>
				</div>
				<?php
					if($_SESSION['userID'] == 1) {
						echo "
							<div class='headerIcon'>
								<a href='orders.php'><img src='../img/system/basketFullRed.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' /></a>
							</div>
						";
					} else {
						$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
						$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

						if($basketQuantity[0] > 0) {
							echo "
								<div class='headerIcon' id='basketIcon'>
									<a href='basket.php' onmouseover='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)'><img src='../img/system/basketFullRed.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
								</div>
								";
						} else {
							echo "
								<div class='headerIcon' id='basketIcon'>
									<a href='basket.php?section=1'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' /></a>
								</div>
							";
						}
					}
				?>
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
		<h1 style='margin-top: 80px;'><?php if($_REQUEST['section'] == 1) {echo "Корзина";} if($_REQUEST['section'] == 2) {echo "Активные заявки";} if($_REQUEST['section'] == 3) {echo "История заказов";} ?></h1>
		<div id='breadCrumbs'>
			<a href='../index.php'><span class='breadCrumbsText'>Главная</span></a> > <?php if($_SESSION['userID'] == 1) {echo "<a href='basket.php?section=1'><span class='breadCrumbsText'>Оформление онлайн-заявок</span></a>";} else {echo "<a href='basket.php?section=1'><span class='breadCrumbsText'>Заказы</span></a> >";} ?>
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
					<a href='basket.php?section=1'><div "; if($_REQUEST['section'] == 1) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb1' onmouseover='buttonChange(\"pb1\", 1)' onmouseout='buttonChange(\"pb1\", 0)'";} echo ">Корзина</div></a>
					<div style='width: 100%; height: 5px;'></div>
					<a href='basket.php?section=2'><div "; if($_REQUEST['section'] == 2) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb2' onmouseover='buttonChange(\"pb2\", 1)' onmouseout='buttonChange(\"pb2\", 0)'";} echo ">Активные заявки</div></a>
					<div style='width: 100%; height: 5px;'></div>
					<a href='basket.php?section=3&p=1'><div "; if($_REQUEST['section'] == 3) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb3' onmouseover='buttonChange(\"pb3\", 1)' onmouseout='buttonChange(\"pb3\", 0)'";} echo ">История заказов</div></a>
				</div>
				<div id='personalContent'>
					<div id='goodResponseFiled'></div>
			";

			$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
			$user = $userResult->fetch_assoc();

			switch($_REQUEST['section']) {
				case 1:
					if($basketQuantity[0] == 0) {
						echo "<span style='font-size: 15px;'><b>На данный момент ваша корзина пуста. Чтобы в ней появились товары, добавьте их <a href='../catalogue.php?type=fa&p=1' style='color: #df4e47;'>из каталога</a></b>.</span>";
					} else {
						echo "<span style='font-size: 15px;'>Всего групп товаров в коризне: <b id='basketQuantityText'>".$basketQuantity[0]."</b></span><br /><br />";
						$total = 0;
						$basketResult = $mysqli->query("SELECT * FROM basket WHERE user_id = '".$_SESSION['userID']."' ORDER BY id");
						while($basket = $basketResult->fetch_assoc()) {
							$goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$basket['good_id']."'");
							$good = $goodResult->fetch_assoc();
							$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
							$unit = $unitResult->fetch_assoc();
							$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
							$currency = $currencyResult->fetch_assoc();
							$price = $good['price'] * $currency['rate'];
							$total += $price * $basket['quantity'];
							$price = $price - $price * ($user['discount'] / 100);
							$price = round($price, 2, PHP_ROUND_HALF_UP);
							$roubles = floor($price);
							$kopeck = ($price - $roubles) * 100;
							if($kopeck == 100) {
								$kopeck = 0;
								$roubles ++;
							}

							echo "
								<div class='catalogueItem' id='ci".$good['id']."'>
									<div class='itemDescription'>
										<div class='catalogueIMG'>
											<a href='../img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='../img/catalogue/small/".$good['small']."' /></a>
										</div>
										<div class='catalogueInfo'>
											<div class='catalogueName'>
												<div style='width: 5px; height: 30px; background-color: #df4e47; position: relative; float: left;'></div>
												<div style='margin-left: 15px;'>".$good['name']."</div>
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
									<span><b>Стоимость за ".$unit['short_name'].": </b>"; if($roubles > 0) {echo $roubles." руб. ";} echo $kopeck." коп.</span>
							";

							if($good['sketch'] != '') {
								echo "<br /><br /><a href='../img/catalogue/sketch/".$good['sketch']."' class='lightview'><span class='sketchFont'>Чертёж</span></a>";
							}

							echo "
												</div>
											</div>
										</div>
									</div>
									<div class='itemPurchase'>
										<img src='../img/system/delete.png' id='deleteIMG".$good['id']."' style='cursor: pointer; float: right;' title='Убрать товар из корзины' onmouseover='changeIcon(\"deleteIMG".$good['id']."\", \"deleteRed.png\", 1)' onmouseout='changeIcon(\"deleteIMG".$good['id']."\", \"delete.png\", 1)' onclick='removeGood(\"".$good['id']."\")' />
										<br /><br />
										<form method='post'>
											<label for='quantityInput".$good['id']."'>Кол-во в ".$unit['in_name'].":</label>
											<input type='number' id='quantityInput".$good['id']."' min='1' step='1' value='".$basket['quantity']."' class='itemQuantityInput' onkeyup='changeQuantity(\"".$good['id']."\")' onchange='changeQuantity(\"".$good['id']."\")' />
										</form>
										<br />
										<div class='addingResult' id='addingResult".$good['id']."' onclick='hideBlock(\"addingResult".$good['id']."\")'></div>
									</div>
									<div style='clear: both;'></div>
								</div>
								<div style='width: 100%; height: 20px;' id='cis".$good['id']."'></div>
								<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;' id='cil".$good['id']."'></div>
								<div style='width: 100%; height: 20px;'></div>
							";
						}

						$total = $total - $total * ($user['discount'] / 100);
						$total = round($total, 2, PHP_ROUND_HALF_UP);
						$roubles = floor($total);
						$kopeck = ceil(($total - $roubles) * 100);
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
							<table style='width: 100%; text-align: center;'>
								<tr class='headTR'>
									<td>№</td>
									<td>Заказ</td>
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
									<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
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
					echo "3333333";
					break;
				default: echo "111111111"; break;
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
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="../contacts.php?page=main">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="http://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>