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

if(empty($_REQUEST['p'])) {
	header("Location: orders.php?section=".$_REQUEST['section']."&p=1");
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
					<a href='orders.php'><img src='../img/system/basketFullRed.png' title='Заявки' id='basketIMG' onmouseover='changeIcon("basketIMG", "basketFull.png", 1)' onmouseout='changeIcon("basketIMG", "basketFullRed.png", 1)' /></a>
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
					<a href='orders.php?section=1&p=1'><div "; if($_REQUEST['section'] == 1) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb1' onmouseover='buttonChange(\"pb1\", 1)' onmouseout='buttonChange(\"pb1\", 0)'";} echo ">Активные заявки</div></a>
					<div style='width: 100%; height: 5px;'></div>
					<a href='orders.php?section=2&p=1'><div "; if($_REQUEST['section'] == 2) {echo "class='personalMenuLinkActive'";} else {echo "class='personalMenuLink' id='pb2' onmouseover='buttonChange(\"pb2\", 1)' onmouseout='buttonChange(\"pb2\", 0)'";} echo ">История заказов</div></a>
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
								<select id='clientSelect' onchange='selectClient()'>
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
									<td>"; if(!empty($user['company'])) {echo $user['company']." — ";} echo $user['name']; echo "</td>
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