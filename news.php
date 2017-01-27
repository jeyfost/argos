<?php

session_start();

include ("scripts/connect.php");

if(!empty($_REQUEST['year'])) {
	$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE year = '".$mysqli->real_escape_string($_REQUEST['year'])."'");
	$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

	if($newsCount[0] == 0) {
		header("Location: news.php");
	}
}

if(!empty($_REQUEST['id'])) {
	$newsCountResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$newsCount = $newsCountResult->fetch_array(MYSQLI_NUM);

	if($newsCount[0] == 0) {
		header("Location: news.php");
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
    <meta name='description' content='Комплексные поставки всех видов мебельной фурнитуры импортного и отечественного производства. Республика Беларусь, г. Могилёв.'>

    <title>Новости</title>

    <link rel='shortcut icon' href='img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='css/style.css'>
	<link rel="stylesheet" type="text/css" href="js/lightview/css/lightview/lightview.css" />
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='css/styleOpera.css'>";
		}
	?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
	<script type="text/javascript" src="js/news.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="js/lightview/js/lightview/lightview.js"></script>
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

<body id="bodyIndex">

    <div id="page-preloader"><span class="spinner"></span></div>

    <div id="menu">
        <div class="container" style="height: 100%;">
            <a href="index.php"><img src="img/system/logo.png" id="logo" /></a>
			<div id="personalButtons">
				<?php
					if(isset($_SESSION['userID'])) {
						echo "
							<div class='headerIcon'>
								<a href='scripts/personal/logout.php'><img src='img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exitRed.png\", 0)' onmouseout='changeIcon(\"exitIMG\", \"exit.png\", 0)' /></a>
							</div>
							<div class='headerIcon'>
								<a href='personal/personal.php?section=1'><img src='img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon(\"personalIMG\", \"personalRed.png\", 0)' onmouseout='changeIcon(\"personalIMG\", \"personal.png\", 0)' /></a>
							</div>
						";
						if($_SESSION['userID'] == 1) {
							echo "
								<div class='headerIcon'>
									<a href='personal/orders.php'><img src='img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)' /></a>
								</div>
							";
						} else {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)'><img src='img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='personal/basket.php'><img src='img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)' /></a>
									</div>
								";
							}
						}
					} else {
						echo "
							<div class='headerIcon'>
								<a href='personal/login.php'><img src='img/system/login.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"loginRed.png\", 0)' onmouseout='changeIcon(\"loginIMG\", \"login.png\", 0)' /></a>
							</div>
						";
					}
					echo "
						<div id='searchBlock'>
							<form method='post'>
								<input type='text' id='searchFieldInput' name=searchField' value='Поиск...' />
							</form>
						</div>
					";
					echo "<div style='clear: both;'></div>";
				?>
			</div>
            <div id="menuLinks">
                <div class="menuLink" id="catalogueLink" onmouseover="showDropdownList('1', 'catalogueLink')">
                    <a href="catalogue.php?type=fa&p=1" class="menuPoint">Каталог</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
                    <a href="about/info.php">О компании</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="news.php" style="color: #df4e47;">Новости</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
                    <a href="stores/company.php">Где купить</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="actions.php">Акции</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink')">
                    <a href="partners/cooperation.php">Партнерам</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="contactsLink" onmouseover="showDropdownList('1', 'contactsLink')">
                    <a href="contacts/stores.php">Контакты</a>
                    <img src="img/system/downArrow.png" />
                </div>
                <div style="clear: both;"></div>
            </div>
        <div style="clear: both;"></div>
        </div>
        <div id="menuIcon"><img src="img/system/mobile/menuIcon.png" title="Меню" /></div>
        <div style="clear: both;"></div>

    </div>
    <div id="dropDownLine">
        <div id="dropDownArrowContainer">
            <img src="img/system/dropDownListArrow.png" id="dropDownArrow" />
        </div>
        <div id="dropDownList"></div>
    </div>
    <div id="menuShadow"></div>

	<div id="page">
		<h1 style='margin-top: 80px;'>Новости</h1>
		<div id='breadCrumbs'>
			<a href='index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='news.php'><span class='breadCrumbsText'>Новости</span></a>
		</div>

		<div style="width: 100%; text-align: right;">
			<span style='color: #4c4c4c; font-style: italic; font-size: 16px;'>Архив: </span>
			<?php
				$yearResult = $mysqli->query("SELECT DISTINCT year FROM news ORDER BY id");
				while($year = $yearResult->fetch_array(MYSQLI_NUM)) {
					echo "<a href='news.php?year=".$year[0]."'><span style='color: #4c4c4c; font-style: italic; font-size: 14px; text-decoration: underline;' class='yearFont'>".$year[0]."</span></a> ";
				}
			?>
		</div>
		<div style="width: 100%; height: 1px; background-color: #c9c9c9; margin-top: 5px;"></div>
		<br />
		<?php
			if(empty($_REQUEST['id'])) {
				if(empty($_REQUEST['year'])) {
					$newsResult = $mysqli->query("SELECT * FROM news order BY id DESC");
				} else {
					$newsResult = $mysqli->query("SELECT * FROM news WHERE year = '".$_REQUEST['year']."' order BY id DESC");
				}

				while($news = $newsResult->fetch_assoc()) {
					$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
					$index = (int)substr($news['date'], 3, 2) - 1;

					$date = substr($news['date'], 0, 2)." ".$month[$index]." ".substr($news['date'], 6, 4);

					echo "
						<a href='news.php?id=".$news['id']."'>
							<div class='newsPreview' id='newsPreview".$news['id']."'>
								<img src='img/photos/news/".$news['preview']."' />
								<br /><br />
								<div style='text-align: left;'>
									<span style='color: #df4e47; font-style: italic; font-size: 14px;'>".$date."</span>
									<p style='color: #4c4c4c; margin-top: 0;'>".$news['header']."</p>
									<br />
									<div style='text-align: right;'><img src='img/system/arrow.png' /></div>
								</div>
							</div>
						</a>
					";
				}
			} else {
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

				$yearNewsResult = $mysqli->query("SELECT * FROM news WHERE year = '".$news['year']."'");
				while($yearNews = $yearNewsResult->fetch_assoc()) {
					$j++;
					$i = (int)substr($yearNews['date'], 3, 2) - 1;
					$d = substr($yearNews['date'], 0, 2)." ".$month[$i]." ".substr($yearNews['date'], 6, 4);

					echo "
						<a href='news.php?id=".$yearNews['id']."'>
							<div class='newsPreview' id='newsPreview".$yearNews['id']."' "; if($j > 1) {echo "style='margin-left: 0;";} else {echo "style='margin: 0;";} if($yearNews['id'] == $_REQUEST['id']) {echo " background-color: #ededed;'";} else {echo "'";} echo ">
								<img src='img/photos/news/".$yearNews['preview']."' />
								<br /><br />
								<div style='text-align: left;'>
									<span style='color: #df4e47; font-style: italic; font-size: 14px;'>".$d."</span>
									<p style='color: #4c4c4c; margin-top: 0;'>".$yearNews['header']."</p>
									<br />
									<div style='text-align: right;'><img src='img/system/arrow.png' /></div>
								</div>
							</div>
						</a>
					";
				}

				echo "
						</div>
					</div>

					<div id='personalContent'>
						<span style='color: #df4e47; font-style: italic; font-size: 14px;'>".$date."</span>
						<br /><br />
						<h2>".$news['header']."</h2>
						<p>".$news['text']."</p>
						<a href='news.php'><span style='color: #df4e47; font-style: italic; font-size: 14px; text-decoration: underline;' class='yearFont'>Больше новостей</span></a>
					</div>
				";
			}
		?>
	</div>

	<div style="clear: both;"></div>
	<div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
		<div class="container">
			<div class="copy">&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - <?php echo date('Y'); ?></div>
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="contacts.php?page=main">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="http://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>