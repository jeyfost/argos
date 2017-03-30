<?php

session_start();
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

    <title>Фотогалерея</title>

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
	<script type="text/javascript" src="../js/about.js"></script>
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
				<?php
					if(isset($_SESSION['userID'])) {
						echo "
							<div class='headerIcon'>
								<a href='../scripts/personal/logout.php'><img src='../img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exitRed.png\", 1)' onmouseout='changeIcon(\"exitIMG\", \"exit.png\", 1)' /></a>
							</div>
							<div class='headerIcon'>
								<a href='../personal/personal.php?section=1'><img src='../img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon(\"personalIMG\", \"personalRed.png\", 1)' onmouseout='changeIcon(\"personalIMG\", \"personal.png\", 1)' /></a>
							</div>
						";
						if($_SESSION['userID'] == 1) {
							echo "
								<div class='headerIcon'>
									<a href='../personal/orders.php'><img src='../img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' /></a>
								</div>
							";
						} else {
							$basketQuantityResult = $mysqli->query("SELECT COUNT(id) FROM basket WHERE user_id = '".$_SESSION['userID']."'");
							$basketQuantity = $basketQuantityResult->fetch_array(MYSQLI_NUM);

							if($basketQuantity[0] > 0) {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='../personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' /><div id='basketLabel'>".$basketQuantity[0]."</div></a>
									</div>
								";
							} else {
								echo "
									<div class='headerIcon' id='basketIcon'>
										<a href='../personal/basket.php'><img src='../img/system/basketFull.png' title='Корзина | Товаров в корзине: ".$basketQuantity[0]."' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 1)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 1)' /></a>
									</div>
								";
							}
						}
					} else {
						echo "
							<div class='headerIcon'>
								<a href='../personal/login.php'><img src='../img/system/login.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"loginRed.png\", 1)' onmouseout='changeIcon(\"loginIMG\", \"login.png\", 1)' /></a>
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
					<a href="../catalogue.php?type=fa&p=1">Каталог</a>
					<img src="../img/system/downArrow.png" />
					<span class="slash"> /</span>
				</div>
				<div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink', 'aboutLinkGallery')">
					<a href="../about/info.php" style="color: #df4e47;">О компании</a>
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
		<h1 style='margin-top: 80px;'>Фотогалерея</h1>
		<div id='breadCrumbs'>
			<a href='../index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='info.php'><span class='breadCrumbsText'>О компании</span></a> > <a href='gallery.php'><span class='breadCrumbsText'>Фотогаллерея</span></a>
		</div>

		<div id="personalMenu">
			<a href='info.php'><div class='personalMenuLink' id='pbl1' onmouseover='buttonChange("pbl1", 1)' onmouseout='buttonChange("pbl1", 0)'>Общая информация</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='assortment.php'><div class='personalMenuLink' id='pbl2' onmouseover='buttonChange("pbl2", 1)' onmouseout='buttonChange("pbl2", 0)'>Ассортимент</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='awards.php'><div class='personalMenuLink' id='pbl3' onmouseover='buttonChange("pbl3", 1)' onmouseout='buttonChange("pbl3", 0)'>Достижения и награды</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='gallery.php'><div class='personalMenuLinkActive'>Фотогалерея</div></a>
			<div style='width: 100%; height: 5px;'></div>
			<a href='vacancies.php'><div class='personalMenuLink' id='pbl5' onmouseover='buttonChange("pbl5", 1)' onmouseout='buttonChange("pbl5", 0)'>Вакансии</div></a>
		</div>

		<div id="personalContent">
			<?php
				$albumResult = $mysqli->query("SELECT * FROM albums ORDER BY name");
				while($album = $albumResult->fetch_assoc()) {
					$photosCountResult = $mysqli->query("SELECT COUNT(id) FROM photos WHERE album = '".$album['id']."'");
					$photosCount = $photosCountResult->fetch_array(MYSQLI_NUM);

					if($photosCount[0] > 0) {
						echo "
							<h2 class='albumName'>".$album['name']."</h2>
							<br />
							<div class='horizontalLine'></div>
							<br />
						";
						$photoResult = $mysqli->query("SELECT * FROM photos WHERE album = '".$album['id']."'");
						while($photo = $photoResult->fetch_assoc()) {
							echo "
								<div class='awardBlock'>
									<a href='../img/photos/gallery/big/".$photo['photo_big']."' class='lightview' data-lightview-title='".$album['name']."' data-lightview-group='album".$album['id']."'><img src='../img/photos/gallery/small/".$photo['photo_small']."' class='galleryPhoto' id='galleryPhoto".$photo['id']."' onmouseover='galleryPhoto(\"galleryPhoto".$photo['id']."\", 1)' onmouseout='galleryPhoto(\"galleryPhoto".$photo['id']."\", 0)' /></a>
								</div>
							";
						}
						echo "<br /><br /><br /><br />";
					}
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