<?php

session_start();

if(!isset($_SESSION['userID'])) {
	header("Location: ../index.php");
} else {
	if($_SESSION['userID'] != 1) {
		header("Location: basket.php?section=1");
	}
}

if(empty($_REQUEST['section'])) {
	header("Location: orders.php?section=1&p=1");
} else {
	if($_REQUEST['section'] != 1 and $_REQUEST['section'] != 2) {
		header("Location: orders.php?section=1&p=1");
	}
}

include("../scripts/connect.php");

if(empty($_REQUEST['p'])) {
	header("Location: orders.php?section=".$_REQUEST['section']."&p=1");
} else {
	if($_REQUEST['section'] == 2) {

		$quantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '1'");
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
	}
}

$page = $mysqli->real_escape_string($_REQUEST['p']);
$start = $page * 10 - 10;

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

    <title><?php if($_REQUEST['section'] == 1) {echo "Активные заявки";} if($_REQUEST['section'] == 2) {echo "История заказов";} ?></title>

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
	<script type="text/javascript" src="../js/orders.js"></script>
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
				<div class='headerIcon'>
					<?php
						$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
						$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

						if($basketQuantity[0] > 0) {
							echo "
								<div class='headerIcon' id='basketIcon'>
									<a href='orders.php?section=1&p=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
								</div>
							";
						} else {
							echo "
								<div class='headerIcon'>
									<a href='orders.php'><img src='../img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' /></a>
								</div>
							";
						}
					?>
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
		<h1 style='margin-top: 80px;'><?php if($_REQUEST['section'] == 1) {echo "Активные заявки";} if($_REQUEST['section'] == 2) {echo "История заказов";} ?></h1>
		<div id='breadCrumbs'>
			<a href='../index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='orders.php?section=1'><span class='breadCrumbsText'>Заявки</span></a> >
			<?php
				switch($_REQUEST['section']) {
					case 1:
						echo "<a href='orders.php?section=1'><span class='breadCrumbsText'>Необработанные заказы</span></a>";
						break;
					case 2:
						echo "<a href='orders.php?section=2'><span class='breadCrumbsText'>История заказов</span></a>";
						break;
					default: break;
				}
			?>
		</div>

		<?php
			echo "
				<div id='personalMenu'>
					<a href='orders.php?section=1&p=1'><div "; if($_REQUEST['section'] == 1) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pbl1' onmouseover='buttonChange(\"pbl1\", 1)' onmouseout='buttonChange(\"pbl1\", 0)'";} echo ">Активные заявки</div></a>
					<div style='width: 100%; height: 5px;'></div>
					<a href='orders.php?section=2&p=1'><div "; if($_REQUEST['section'] == 2) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pbl2' onmouseover='buttonChange(\"pbl2\", 1)' onmouseout='buttonChange(\"pbl2\", 0)'";} echo ">История заказов</div></a>
				</div>
				<div id='personalContent'>
					<div id='goodResponseFiled'></div>
			";

			switch($_REQUEST['section']) {
				case 1:
					$ordersQuantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '0'");
					$ordersQuantity = $ordersQuantityResult->fetch_array(MYSQLI_NUM);

					if($ordersQuantity[0] == 0) {
						echo "<span style='font-size: 15px;'><b>На данный момент необработанных заявок нет.</b></span>";
					} else {
						$j = 0;
						$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '0'");
						echo "
							<p>Активные заявки — это заказы, которые ещё не были утверждены. До момента принятия заказа необходимо созвониться с клиентом для подтверждения и уточнения итоговой стоимости. </p>
							<form method='post'>
								<label for='clientSelect'>Клиент:</label>
								<br />
								<select id='clientSelect' onchange='selectClient(\"ajaxSelectClient\")'>
									<option value='all' selected>- Все клиенты -</option>
						";
						$clientIDResult = $mysqli->query("SELECT DISTINCT user_id FROM orders_info WHERE status = '0'");
						while($clientID = $clientIDResult->fetch_array(MYSQLI_NUM)) {
							$clientResult = $mysqli->query("SELECT * FROM users WHERE id = '".$clientID[0]."'");
							$client = $clientResult->fetch_assoc();
							echo "<option value='".$clientID[0]."'>"; if(!empty($client['company'])) {echo $client['company']." — ";} echo $client['name']; echo "</option>";
						}
						echo "
								</select>
							</form>
							<br /><br />
							<div id='orderResponse'></div>
							<table style='min-width: 100%; text-align: center;' id='ordersTable'>
								<tr class='headTR'>
									<td>№</td>
									<td>Заказ</td>
									<td>Дата оформления</td>
									<td>Клиент</td>
									<td>Принять заказ</td>
									<td>Отмена заказа</td>
								</tr>
						";
						while($order = $orderResult->fetch_assoc()) {
							$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
							$user = $userResult->fetch_assoc();
							$j++;
							echo "
								<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
									<td>".$j."</td>
									<td><span class='tdLink' onclick='showOrderDetails(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
									<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
									<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
									<td><span class='tdLink' onclick='acceptOrder(\"".$order['id']."\")'>Принять заказ</span></td>
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
				case 2:
					$j = 0;
					echo "
						<form method='post'>
							<label for='clientSelect'>Клиент:</label>
							<br />
							<select id='clientSelect' onchange='selectClient(\"ajaxSelectClientHistory\")'>
								<option value='all' selected>- Все клиенты -</option>
					";

					$clientIDResult = $mysqli->query("SELECT DISTINCT user_id FROM orders_info WHERE status = '1'");
					while($clientID = $clientIDResult->fetch_array(MYSQLI_NUM)) {
						$clientResult = $mysqli->query("SELECT * FROM users WHERE id = '".$clientID[0]."'");
						$client = $clientResult->fetch_assoc();
						echo "<option value='".$clientID[0]."'>"; if(!empty($client['company'])) {echo $client['company']." — ";} echo $client['name']; echo "</option>";
					}
					echo "
							</select>
						</form>
						<br /><br />
						<div id='orderResponse'></div>
						<table style='min-width: 100%; text-align: center;' id='ordersTable'>
							<tr class='headTR'>
								<td>№</td>
								<td>Заказ</td>
								<td>Клиент</td>
								<td>Дата оформления</td>
								<td>Дата принятия</td>
							</tr>
					";

					$orderResult = $mysqli->query("SELECT * FROM orders_info WHERE status = '1' ORDER BY id DESC LIMIT ".$start.", 10");
					while($order = $orderResult->fetch_assoc()) {
						$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$order['user_id']."'");
						$user = $userResult->fetch_assoc();
						$j++;

						echo "
							<tr"; if($j % 2 == 0) {echo " style='background-color: #ddd;'";} echo ">
								<td>".($page * 10 - 10 + $j)."</td>
								<td><span class='tdLink' onclick='showOrderDetailsHistory(\"".$order['id']."\")' title='Открыть детализацию заказа'>Заказ №".$order['id']."</span></td>
								<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']." — ".$user['phone']; echo "</td>
								<td>".substr($order['send_date'], 0, 10)." в ".substr($order['send_date'], 11, 8)."</td>
								<td>".substr($order['proceed_date'], 0, 10)." в ".substr($order['proceed_date'], 11, 8)."</td>
							</tr>
						";
					}

					echo "
						</table>
						<div id='pageNumbers'>
					";

					if($numbers > 1) {
						$uri = explode("&p=", $_SERVER['REQUEST_URI']);
						$link = $uri[0]."&p=";
						if($numbers <= 7) {
							echo "<br /><br />";

							if($_REQUEST['p'] == 1) {
								echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
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
								echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
							} else {
								echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
							}

							echo "</div>";

						} else {
							if($_REQUEST['p'] < 5) {
								if($_REQUEST['p'] == 1) {
									echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
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

								echo "<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
								echo "<a href='".$link.$numbers."' class='noBorder'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>";

								if($_REQUEST['p'] == $numbers) {
									echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
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
										echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
									} else {
										echo "<a href='".$link.($_REQUEST['p'] + 1)."' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
									}
								}
							}
						}
					}

					echo "
							<br /><br />
							<div id='responseField'></div>
							</div>
							<div style='clear: both;'>
						</div>
					";
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
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="../contacts.php?page=main">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="http://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>