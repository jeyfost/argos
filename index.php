<?php

session_start();

include ("scripts/connect.php");

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">
    <meta name='keywords' content='мебельная фурнитура, комплектующие для мебели, Аргос-ФМ, комплектующие для мебели Могилев, Могилев, кромочные материалы, кромка, кромка ПВХ, ручки мебельные, мебельная фурнитура Могилев, кромка ПВХ Могилев, лента кромочная, лента кромочная Могилев, ручки мебельные Могилев, кромка Могилев'>
    <meta name='description' content='Комплексные поставки всех видов мебельной фурнитуры импортного и отечественного производства. Республика Беларусь, г. Могилёв.'>

    <title>Аргос-ФМ | Мебельная фурнитура</title>

    <link rel='shortcut icon' href='img/icons/favicon.ico' type='image/x-icon'>
	<link rel='icon' href='img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='css/style.css'>
    <?php
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			echo "<link rel='stylesheet' media='screen' type='text/css' href='css/styleOpera.css'>";
		}
	?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
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
					if(empty($_SESSION['userID'])) {
						echo "<a href='personal/login.php'><img src='img/system/login.png' title='Войти под своей учётной записью' id='loginIMG' onmouseover='changeIcon(\"loginIMG\", \"loginRed.png\", 0)' onmouseout='changeIcon(\"loginIMG\", \"login.png\", 0)' /></a>";
					} else {
						echo "<a href='scripts/personal/logout.php'><img src='img/system/exit.png' title='Выйти из своей учётной записи' id='exitIMG' onmouseover='changeIcon(\"exitIMG\", \"exitRed.png\", 0)' onmouseout='changeIcon(\"exitIMG\", \"exit.png\", 0)' /></a>";
					}
				?>
			</div>
            <div id="menuLinks">
                <div class="menuLink" id="catalogueLink" onmouseover="showDropdownList('1', 'catalogueLink')">
                    <a href="catalogue.php" class="menuPoint">Каталог</a>
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

    <div id="mainImg">
        <div class="mainImgContainer" id="mic1"><img src="img/system/main1.jpg" id="mainImg1" /></div>
        <div class="mainImgContainer" id="mic2"><img src="img/system/main2.jpg" id="mainImg2" /></div>
        <div class="mainImgContainer" id="mic3"><img src="img/system/main3.jpg" id="mainImg3" /></div>
        <div class="mainImgContainer" id="mic4"><img src="img/system/main4.jpg" id="mainImg4" /></div>

        <div id="leftSideBlock">
            <span id="mainText1" class="mainBigText" onclick="scrollFirst()">Мебельная фурнитура</span>
            <br /><br />
            <span id='mainText2' class="mainSmallText" onclick="scrollSecond()">Кромочные материалы</span>
            <br /><br />
            <span id='mainText3' class="mainSmallText" onclick="scrollThird()">Аксессуары для штор</span>
            <br /><br />
            <span id='mainText4' class="mainSmallText" onclick="scrollFourth()">Сопутствующие товары</span>
        </div>
        <div id="rightSideBlock" class="rightSideBlock">
            <div class="rightSideBlockHeader">Разделы</div>
            <div class="rsbSpace"></div>
            <div class="rsbLine"></div>
            <div class="rsbSpace"></div>
            <ul id="rightSideBlockCategories">
                <?php
                $categoriesCountResult = $mysqli->query("SELECT COUNT(id) from categories_new WHERE type = 'fa'");
                $categoriesCount = $categoriesCountResult->fetch_array(MYSQLI_NUM);

                if($categoriesCount[0] > 10) {
                    $categoriesResult = $mysqli->query("SELECT * FROM categories_new WHERE type = 'fa' ORDER BY name LIMIT 10");
                    while($categories = $categoriesResult->fetch_assoc()) {
                        echo "<li><a href='catalogue.php?type=".$categories['type']."&c=".$categories['id']."&p=1'>".$categories['name']."</a></li>";
                    }

                    echo "<li><a href='catalogue.php?type=".$categories['type']."&p=1'>+ Другие разделы</a></li>";
                } else {
					$categoriesResult = $mysqli->query("SELECT * FROM categories_new WHERE type = 'fa' ORDER BY name");

                    while($categories = $categoriesResult->fetch_assoc()) {
                        echo "<li><a href='catalogue.php?type=".$categories['type']."&c=".$categories['id']."&p=1'>".$categories['name']."</a></li>";
                    }
                }
            ?>
            </ul>
        </div>
    </div>

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