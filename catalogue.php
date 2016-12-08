<?php

session_start();
include("scripts/connect.php");

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

if(empty($_REQUEST['type'])) {
	header("Location: catalogue.php?type=fa&p=1");
} else {
	$typeResult = $mysqli->query("SELECT * FROM types WHERE catalogue_type = '".$mysqli->real_escape_string($_REQUEST['type'])."'");

	if($typeResult->num_rows == 0) {
		header("Location: catalogue.php?type=fa&p=1");
	}
}

if(!empty($_REQUEST['c'])) {
	$cResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['c'])."'");
	if($cResult->num_rows == 0) {
		header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&p=1");
	} else {
		$c = $cResult->fetch_assoc();
		if($c['type'] != $mysqli->real_escape_string($_REQUEST['type'])) {
			header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&p=1");
		}
	}
}

if(!empty($_REQUEST['s']) and empty($_REQUEST['c'])) {
	header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&p=1");
}

if(!empty($_REQUEST['s'])) {
	$sResult = $mysqli->query("SELECT * FROM subcategories_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['s'])."'");
	if($sResult->num_rows == 0) {
		header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&p=1");
	} else {
		$s = $sResult->fetch_assoc();
		if($s['category'] != $mysqli->real_escape_string($_REQUEST['c'])) {
			header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&p=1");
		}
	}
}

if(!empty($_REQUEST['s2']) and empty($_REQUEST['s'])) {
	header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&s=".$mysqli->real_escape_string($_REQUEST['s'])."&p=1");
}

if(!empty($_REQUEST['s2'])) {
	$s2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE id = '".$mysqli->real_escape_string($_REQUEST['s2'])."'");
	if($s2Result->num_rows == 0) {
		header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&s=".$mysqli->real_escape_string($_REQUEST['s'])."&p=1");
	} else {
		$s2 = $s2Result->fetch_assoc();
		if($s2['subcategory'] != $mysqli->real_escape_string($_REQUEST['s'])) {
			header("Location: catalogue.php?type=".$mysqli->real_escape_string($_REQUEST['type'])."&c=".$mysqli->real_escape_string($_REQUEST['c'])."&s=".$mysqli->real_escape_string($_REQUEST['s'])."&p=1");
		}
	}
}

if(empty($_REQUEST['p'])) {
	header("Location: ".$_SERVER['REQUEST_URI']."&p=1");
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

    <link rel='shortcut icon' href='img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='css/style.css'>
	<link rel="stylesheet" type="text/css" href="js/lightview/css/lightview/lightview.css" />
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='css/styleOpera.css'>";
		}
	?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
	<script type="text/javascript" src="js/catalogue.js"></script>
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

<body>

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
								<a href='scripts/personal/personal.php'><img src='img/system/personal.png' title='Личный кабинет' id='personalIMG' onmouseover='changeIcon(\"personalIMG\", \"personalRed.png\", 0)' onmouseout='changeIcon(\"personalIMG\", \"personal.png\", 0)' /></a>
							</div>
						";
						if($_SESSION['userID'] == 1) {
							echo "
								<div class='headerIcon'>
									<a href='scripts/personal/orders.php'><img src='img/system/basketFull.png' title='Заявки' id='basketIMG' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\", 0)' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\", 0)' /></a>
								</div>
							";
						} else {

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
                <div class="menuLink" id="catalogueLink" <?php echo "onmouseover='showDropdownList(\"1\", \"catalogueLink\", \"catalogueLink".strtoupper($mysqli->real_escape_string($_REQUEST['type']))."\")'"; ?>>
                    <a href="catalogue.php?type=fa&p=1" class="menuPoint" style="color: #df4e47;">Каталог</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="aboutLink" onmouseover="showDropdownList('1', 'aboutLink')">
                    <a href="about.php">О компании</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="news.php">Новости</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="storesLink" onmouseover="showDropdownList('1', 'storesLink')">
                    <a href="stores.php">Где купить</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLinkNotDD">
                    <a href="actions.php">Акции</a>
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="partnersLink" onmouseover="showDropdownList('1', 'partnersLink')">
                    <a href="partners.php">Партнерам</a>
                    <img src="img/system/downArrow.png" />
                    <span class="slash"> /</span>
                </div>
                <div class="menuLink" id="contactsLink" onmouseover="showDropdownList('1', 'contactsLink')">
                    <a href="contacts.php">Контакты</a>
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
		<div id='searchList'></div>
		<?php
			$type = $typeResult->fetch_assoc();
			echo "
				<h1 style='margin-top: 80px;'>".$type['type_name']."</h1>
				<div id='breadCrumbs'>
				<a href='index.php'><span class='breadCrumbsText'>Главная</span></a> > <a href='catalogue.php?type=fa&p=1'><span class='breadCrumbsText'>Каталог</span></a> > <a href='catalogue.php?type=".$type['catalogue_type']."&p=1'><span class='breadCrumbsText'>".$type['type_name']."</span></a>
			";

			if(!empty($_REQUEST['c'])) {
				$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE id = '" . $mysqli->real_escape_string($_REQUEST['c']) . "'");
				$category = $categoryResult->fetch_assoc();

				echo " > <a href='catalogue.php?type=" . $type['catalogue_type'] . "&c=" . $category['id'] . "&p=1'><span class='breadCrumbsText'>" . $category['name'] . "</span></a>";
			}

			if(!empty($_REQUEST['s'])) {
				$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['s'])."'");
				$subcategory = $subcategoryResult->fetch_assoc();

				echo " > <a href='catalogue.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&p=1'><span class='breadCrumbsText'>".$subcategory['name']."</span></a>";
			}

			if(!empty($_REQUEST['s2'])) {
				$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE id = '".$mysqli->real_escape_string($_REQUEST['s2'])."'");
				$subcategory2 = $subcategory2Result->fetch_assoc();

				echo " > <a href='catalogue.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&s2=".$subcategory2['id']."&p=1'><span class='breadCrumbsText'>".$subcategory2['name']."</span></a>";
			}

			echo "
			</div>
			";
		?>
		<div id="catalogueMenu">
			<?php
				echo "
					<center><a href='catalogue.php?type=".$type['catalogue_type']."&p=1'><span style='color: #df4e47;'>".$type['type_name']."</span></a></center>
					<div style='width: 100%; height: 1px; background-color: #d7d5d1; margin-top: 10px;'></div>
					<div style='margin-top: 10px; width: 100%;'></div>
				";

				$categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$type['catalogue_type']."' ORDER BY name");
				while($category = $categoryResult->fetch_assoc()) {
					echo "
						<a href='catalogue.php?type=".$type['catalogue_type']."&c=".$category['id']."&p=1'"; if($_REQUEST['c'] != $category['id']) {echo " onmouseover='categoryStyle(1, \"categoryIMG".$category['id']."\", \"categoryText".$category['id']."\", \"".$category['picture']."\", \"".$category['picture_red']."\")' onmouseout='categoryStyle(0, \"categoryIMG".$category['id']."\", \"categoryText".$category['id']."\", \"".$category['picture']."\", \"".$category['picture_red']."\")'";} echo "><div class='categoryContainer'><img src='img/icons/"; if($_REQUEST['c'] == $category['id']) {echo $category['picture_red'];} else {echo $category['picture'];} echo "' id='categoryIMG".$category['id']."' /><div class='categoryNameContainer'><span id='categoryText".$category['id']."'"; if($_REQUEST['c'] == $category['id']) {echo " style='color: #df4e47;'";} echo ">".$category['name']."</span></div></div></a>
					";

					if(!empty($_REQUEST['c']) and $category['id'] == $_REQUEST['c']) {
						$subcategoriesCountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$category['id']."'");
						$subcategoriesCount = $subcategoriesCountResult->fetch_array(MYSQLI_NUM);

						if($subcategoriesCount[0] > 0) {
							$subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$mysqli->real_escape_string($_REQUEST['c'])."' ORDER BY name");
							while($subcategory = $subcategoryResult->fetch_assoc()) {
								echo "<a href='catalogue.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&p=1'"; if($_REQUEST['s'] != $subcategory['id']) {echo " onmouseover='subcategoryStyle(1, \"subcategoryText".$subcategory['id']."\")' onmouseout='subcategoryStyle(0, \"subcategoryText".$subcategory['id']."\")'";} echo "><div class='subcategoryContainer'><span id='subcategoryText".$subcategory['id']."'"; if($_REQUEST['s'] == $subcategory['id']) {echo " style='color: #df4e47;'";} echo ">— ".$subcategory['name']."</span></div></a>";

								if(!empty($_REQUEST['s']) and $subcategory['id'] == $_REQUEST['s']) {
									$subcategories2CountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
									$subcategories2Count = $subcategories2CountResult->fetch_array(MYSQLI_NUM);

									if($subcategories2Count[0] > 0) {
										$subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$subcategory['id']."' ORDER BY name");
										while($subcategory2 = $subcategory2Result->fetch_assoc()) {
											echo "<a href='catalogue.php?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&s2=".$subcategory2['id']."&p=1'"; if($_REQUEST['s2'] != $subcategory2['id']) {echo " onmouseover='subcategoryStyle(1, \"subcategory2Text".$subcategory2['id']."\")' onmouseout='subcategoryStyle(0, \"subcategory2Text".$subcategory2['id']."\")'";} echo "><div class='subcategory2Container'><span id='subcategory2Text".$subcategory2['id']."'"; if($_REQUEST['s2'] == $subcategory2['id']) {echo " style='color: #df4e47;'";} echo ">— ".$subcategory2['name']."</span></div></a>";
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
						<a href='catalogue.php?type=".$types['catalogue_type']."&p=1' onmouseover='subcategoryStyle(1, \"type".$types['id']."\")' onmouseout='subcategoryStyle(0, \"type".$types['id']."\")'><span id='type".$types['id']."'>".$types['type_name']."</span></a>
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

				$currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$catalogue['currency']."'");
				$currency = $currencyResult->fetch_assoc();

				$price = $catalogue['price'] * $currency['rate'];
				$price = round($price, 2, PHP_ROUND_HALF_UP);

				$roubles = floor($price);
				$kopeck = ($price - $roubles) * 100;


				echo "
					<div class='catalogueItem'>
						<div class='itemDescription'>
							<div class='catalogueIMG'>
								<a href='img/catalogue/big/".$catalogue['picture']."' class='lightview' data-lightview-title='".$catalogue['name']."' data-lightview-caption='".nl2br(strip_tags($catalogue['description']))."'><img src='img/catalogue/small/".$catalogue['small']."' /></a>
							</div>
							<div class='catalogueInfo'>
								<div class='catalogueName'>
									<div style='width: 5px; height: 30px; background-color: #df4e47; position: relative; float: left;'></div>
									<div style='margin-left: 15px;'>".$catalogue['name']."</div>
									<div style='clear: both;'></div>
								</div>
								<div class='catalogueDescription'>
				";
				$strings = explode("<br />", $catalogue['description']);
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
									<b>Артикул: </b>".$catalogue['code']."
									<br />
									<div id='goodPrice".$catalogue['id']."'>
										<span"; if($_SESSION['userID'] == 1) {echo " style='cursor: pointer;' onclick='changePrice(\"".$catalogue['id']."\", \"goodPrice".$catalogue['id']."\", \"".$catalogue['price']."\", \"".$currency['code']."\", \"".$unit['short_name']."\", \"".$currency['rate']."\")' title='Изменить стоимость товара'";} echo "><b>Стоимость за ".$unit['short_name'].": </b>"; if($roubles > 0) {echo $roubles." руб. ";} echo $kopeck." коп.</span>
									</div>
								</div>
							</div>
							<div style='clear: both;'></div>
						</div>
				";

				if(isset($_SESSION['userID'])) {
					echo "
						<div class='itemPurchase'>
							<img src='img/system/toBasket.png' id='toBasketIMG".$catalogue['id']."' class='toBasketIMG' onmouseover='changeIcon(\"toBasketIMG".$catalogue['id']."\", \"toBasketRed.png\", 0)' onmouseout='changeIcon(\"toBasketIMG".$catalogue['id']."\", \"toBasket.png\", 0)' title='Добавить в корзину' onclick='addToBasket(\"".$catalogue['id']."\", \"quantityInput".$catalogue['id']."\", \"addingResult".$catalogue['id']."\")' />
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
			<div class="copy" style="margin-left: 40px;">Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href="contacts.php?page=main">Контактная информация</a></div>
			<div class="copy" style="float: right;">Разработка сайта<br /><a href="http://airlab.by/">airlab</a></div>
		</div>
		<div style="clear: both;"></div>
	</div>

</body>

</html>