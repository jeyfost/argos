<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 31.05.2022
 * Time: 14:24
 */

session_start();
include("../../scripts/connect.php");

if(isset($_SESSION['userID'])) {
    if($_SESSION['userID'] != 1) {
        header("Location: ../../");
    } else {
        $userLoginResult = $mysqli->query("SELECT login from users WHERE id = '".$_SESSION['userID']."'");
        $userLogin = $userLoginResult->fetch_array(MYSQLI_NUM);
    }
} else {
    header("Location: ../index.php");
}

if(!empty($_REQUEST['quantity']) and $_REQUEST['quantity'] != 10) {
    $quantity = $mysqli->real_escape_string($_REQUEST['quantity']);
} else {
    $quantity = 10;
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Топ товаров</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>
    <link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
    <script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/admin/admin.js"></script>
    <script type="text/javascript" src="/js/admin/goods/top.js"></script>

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

<body style="background-color: #e4e4e4;">

    <div id="page-preloader"><span class="spinner"></span></div>

    <div id="menu">
        <div id="logo">
            <a href="/"><img src="/img/system/logo.png" /></a>
        </div>
        <div class="line"></div>
        <a href="/admin/goods/">
            <div class="menuPointActive">
                <div class="menuIMG"><img src="/img/system/admin/goods.png" /></div>
                <div class="menuText">Товары</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/sections/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/sections.png" /></div>
                <div class="menuText">Разделы</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/news/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/news.png" /></div>
                <div class="menuText">Новости</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/actions/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/sale.png" /></div>
                <div class="menuText">Акции</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/photo/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/photo.png" /></div>
                <div class="menuText">Фотогалерея</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/albums/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/album.png" /></div>
                <div class="menuText">Альбомы</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/achievements/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/achievement.png" /></div>
                <div class="menuText">Достижения</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/vacancies/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/person.png" /></div>
                <div class="menuText">Вакансии</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/clients/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/clients.png" /></div>
                <div class="menuText">Клиентская база</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/employees/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/employees.png" /></div>
                <div class="menuText">Сотрудники</div>
            </div>
        </a>
        <div class="line"></div>
        <a href="/admin/email/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/mail.png" /></div>
                <div class="menuText">Email-рассылки</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/admin/messages/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/messages.png" /></div>
                <div class="menuText">Сообщения</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
        <a href="/">
            <div class="menuPoint">
                <div class="menuIMG"><img src="/img/system/admin/home.png" /></div>
                <div class="menuText">Вернуться на сайт</div>
            </div>
        </a>
        <div style="clear: both;"></div>
        <div class="line"></div>
    </div>

    <div id="content">
        <div id="top">
            <div id="topText">
                <span style="font-size: 18px; font-weight: bold;">Панель администрирования</span>
                <br />
                <span style="font-size: 14px;">Вы вошли как пользователь <b style="color: #ff282b;"><?php echo $userLogin[0]; ?></b></span>
            </div>
            <a href="/"><img src="/img/system/exit.png" id="exitIMG" title="Выйти из панели администрирования" onmouseover="changeIcon('exitIMG', 'exitRed.png')" onmouseout="changeIcon('exitIMG', 'exit.png')" /></a>
        </div>
        <br />
        <div id="admContent">
            <div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/product.png" title="Товары" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Товары</span></a> > <a href="top.php"><span class="breadCrumbsText">Топ товаров</span></a></div></div>
            <div style="clear: both;"></div>
            <br />
            <h2>Топ товаров</h2>
            <a href="add.php"><input type="button" class="button" id="addButton" value="Добавление" style="margin-left: 0;" onmouseover="buttonChange('addButton', 1)" onmouseout="buttonChange('addButton', 0)" /></a>
            <a href="edit.php"><input type="button" class="button" id="editButton" value="Редактирование" onmouseover="buttonChange('editButton', 1)" onmouseout="buttonChange('editButton', 0)" /></a>
            <a href="delete.php"><input type="button" class="button" id="deleteButton" value="Удаление" onmouseover="buttonChange('deleteButton', 1)" onmouseout="buttonChange('deleteButton', 0)" /></a>
            <a href="update.php"><input type="button" class="button" id="correctionButton" value="Выгрузка 1С" onmouseover="buttonChange('correctionButton', 1)" onmouseout="buttonChange('correctionButton', 0)" /></a>
            <a href="codes.php"><input type="button" class="button" id="codesButton" value="Артикулы" onmouseover="buttonChange('codesButton', 1)" onmouseout="buttonChange('codesButton', 0)" /></a>
            <a href="top.php"><input type="button" class="buttonActive" id="topButton" value="Топ товаров" /></a>
            <div style="clear: both;"></div>
            <br /><br />
            <form id="quantityForm" method="post">
                <label for="quantityInput">Укажите количество позиций в топ-листе:</label>
                <br />
                <input type="number" min="1" max="1000" step="1" id="quantityInput" name="quantity" value="<?= $quantity ?>" onblur="changeTopQuantity('<?= $quantity ?>')" />
                <br /><br />
                <input type="button" id="changeQuantityButton" class="button" value="Сформировать" onmouseover='buttonChange("changeQuantityButton", 1)' onmouseout='buttonChange("changeQuantityButton", 0)' style='margin: 0;' onclick='changeTopQuantity('<?= $quantity ?>')' />
            </form>
            <br /><br /><br />
            <h2>Таблица топ-<?= $quantity ?> товаров</h2>
            <table style="text-align: center;">
                <thead style="font-weight: bold;">
                    <tr>
                        <td style="background-color: #ededed;">№</td>
                        <td style="background-color: #ededed; width: 100px;">Фото</td>
                        <td style="background-color: #ededed; width: 100px;">Артикул</td>
                        <td style="background-color: #ededed;">Название</td>
                        <td style="background-color: #ededed;">Просмотры</td>
                    </tr>
                </thead>
                <?php
                    $i = 0;
                    $goodResult = $mysqli->query("SELECT * FROM catalogue_new ORDER BY views_count DESC LIMIT ".$quantity);
                    while ($good = $goodResult->fetch_assoc()) {
                        $i++;
                        if($i != $quantity) {
                            $color = "#999";
                        } else {
                            $color = "#fff";
                        }
                        echo "
                            <tr>
                                <td style='background-color: #ededed; border-bottom: 1px dashed ".$color.";'>".$i."</td>
                                <td style='width: 100px; border-bottom: 1px dashed ".$color.";'>
                                    <a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
                                </td>
                                <td style='background-color: #ededed; border-bottom: 1px dashed ".$color.";'>".$good['code']."</td>
                                <td style='border-bottom: 1px dashed ".$color.";'><a href='/catalogue/item.php?id=".$good['id']."' target='_blank'><span class='link'>".$good['name']."</span></a></td>
                                <td style='background-color: #ededed; border-bottom: 1px dashed ".$color.";'>".$good['views_count']."</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        </div>
        <div style="clear: both;"></div>
        <div style="width: 100%; height: 40px;"></div>
    </div>

    <div style="clear: both;"></div>

</body>

</html>
