<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2019
 * Time: 12:03
 */

session_start();

include ("scripts/connect.php");
include ("layouts/footer.php");

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

    <title>Акции</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/style.css'>
    <link rel="stylesheet" href="/js/font-awesome-4.7.0/css/font-awesome.min.css">

    <?php
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
            echo "<link rel='stylesheet' media='screen' type='text/css' href='/css/styleOpera.css'>";
        }
    ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="/js/menu.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>

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
                                    <input type='text' id='searchFieldInput' name='searchField' value='Поиск...' />
                                </form>
                            </div>
                        ";
                echo "<div style='clear: both;'></div>";
                ?>
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
        <h1 style='margin-top: 80px;'>Карта сайта</h1>
        <div id='breadCrumbs'>
            <a href='/'><span class='breadCrumbsText'>Главная</span></a> > <a href='/sitemap.php'><span class='breadCrumbsText'>Карта сайта</span></a>
        </div>
        <ol>
            <li><a href="/catalogue" class="headLink">Каталог</a>
            <br />
                <ul type="disc">
                    <?php
                        $typeResult = $mysqli->query("SELECT * FROM types ORDER BY id");
                        while ($type = $typeResult->fetch_assoc()) {
                            echo "
                                <li>
                                    <a href='/catalogue/?type=".$type['catalogue_type']."&p=1' class='link' style='font-weight: bold;'>".$type['type_name']."</a>
                            ";

                            $categoriesCountResult = $mysqli->query("SELECT COUNT(id) FROM categories_new WHERE type = '".$type['catalogue_type']."'");
                            $categoriesCount = $categoriesCountResult->fetch_array(MYSQLI_NUM);

                            if($categoriesCount[0] > 0) {
                                $categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$type['catalogue_type']."' ORDER BY name");
                                echo "
                                    <div class='innerLinkBlock'>
                                        <ul type='square'>    
                                ";

                                while ($category = $categoryResult->fetch_assoc()) {
                                    echo "<li><a href='/catalogue/?type=".$type['catalogue_type']."&c=".$category['id']."&p=1' class='link'>".$category['name']."</a>";

                                    $subcategoriesCountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories_new WHERE category = '".$category['id']."'");
                                    $subcategoriesCount = $subcategoriesCountResult->fetch_array(MYSQLI_NUM);

                                    if($subcategoriesCount[0] > 0) {
                                        echo "<ul type='circle'>";

                                        $subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$category['id']."' ORDER BY name");
                                        while($subcategory = $subcategoryResult->fetch_assoc()) {
                                            echo "<li><a href='/catalogue/?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&p=1' class='link'>".$subcategory['name']."</a>";

                                            $subcategories2CountResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
                                            $subcategories2Count = $subcategories2CountResult->fetch_array(MYSQLI_NUM);

                                            if($subcategories2Count[0] > 0) {
                                                echo "<ul type='disc'>";

                                                $subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$subcategory['id']."' ORDER BY name");
                                                while($subcategory2 = $subcategory2Result->fetch_assoc()) {
                                                    echo "<li><a href='/catalogue/?type=".$type['catalogue_type']."&c=".$category['id']."&s=".$subcategory['id']."&s2=".$subcategory2['id']."&p=1' class='link'>".$subcategory2['name']."</a>";

                                                    $goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory2 = '".$subcategory2['id']."'");
                                                    $goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

                                                    if($goodsCount[0] > 0) {
                                                        echo "<ol>";

                                                        $goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory2 = '".$subcategory2['id']."' ORDER BY name");
                                                        while ($good = $goodResult->fetch_assoc()) {
                                                            echo "<li><a href='/catalogue/item.php?id=".$good['id']."' class='link'>".$good['name']."</a></li>";
                                                        }

                                                        echo "</ol>";
                                                    }

                                                    echo "</li>";
                                                }

                                                echo "</ul>";
                                            } else {
                                                $goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory = '".$subcategory['id']."' ORDER BY name");
                                                $goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

                                                if($goodsCount[0] > 0) {
                                                    echo "<ol>";

                                                    $goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE subcategory = '".$subcategory['id']."' ORDER BY name");
                                                    while ($good = $goodResult->fetch_assoc()) {
                                                        echo "<li><a href='catalogue/item.php?id=".$good['id']."' class='link'>".$good['name']."</a></li>";
                                                    }

                                                    echo "</ol>";
                                                }
                                            }

                                            echo "</li>";
                                        }

                                        echo "</ul>";
                                    } else {
                                        $goodsCountResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE category = '".$category['id']."'");
                                        $goodsCount = $goodsCountResult->fetch_array(MYSQLI_NUM);

                                        if($goodsCount[0] > 0) {
                                            echo "<ol>";

                                            $goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".$category['id']."'");
                                            while ($good = $goodResult->fetch_assoc()) {
                                                echo "<li><a href='/catalogue/item.php?id=".$good['id']."' class='link'>".$good['name']."</a></li>";
                                            }

                                            echo "</ol>";
                                        }
                                    }

                                    echo "</li>";
                                }
                                echo "
                                        </ul>
                                    </div>
                                ";
                            }

                            echo "</li>";
                        }
                    ?>
                </ul>
            </li>
            <li>
                <a href="/about" class="headLink">О компании</a>

                <ul type="square">
                    <li><a href="/about/info.php" class="link">Общая информация</a></li>
                    <li><a href="/about/assortment.php" class="link">Ассортимент</a></li>
                    <li><a href="/about/awards.php" class="link">Достижения и награды</a></li>
                    <li><a href="/about/gallery.php" class="link">Фотогалерея</a></li>
                    <li><a href="/about/vacancies.php" class="link">Вакансии</a></li>
                </ul>
            </li>
            <li><a href="/news.php" class="headLink">Новости</a></li>
            <li>
                <a href="/stores" class="headLink">Где купить</a>

                <ul type="square">
                    <li><a href="/stores/company.php" class="link">Фирменная сеть</a></li>
                    <li><a href="/stores/representatives.php" class="link">Партнёрская сеть</a></li>
                </ul>
            </li>
            <li><a href="/actions.php" class="headLink">Акции</a></li>
            <li>
                <a href="/partners" class="headLink">Партнёрам</a>

                <ul type="square">
                    <li><a href="/partners/cooperation.php" class="link">Сотрудничество</a></li>
                    <li><a href="/partners/news.php" class="link">Новости для клиентов</a></li>
                </ul>
            </li>
            <li>
                <a href="/contacts" class="headLink">Контакты</a>

                <ul type="square">
                    <li><a href="/contacts/stores.php" class="link">Магазины</a></li>
                    <li><a href="/contacts/main.php" class="link">Головное предприятие</a></li>
                    <li><a href="/contacts/mail.php" class="link">Обратная связь</a></li>
                </ul>
            </li>
        </ol>
    </div>

    <div style="clear: both;"></div>
    <div id="space"></div>

    <div id="footerShadow"></div>
    <div id="footer">
        <?= footer() ?>
    </div>

</body>
