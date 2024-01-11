<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 10.01.2024
 * Time: 10:00
 */

session_start();
include("../../../scripts/connect.php");

if(isset($_SESSION['userID'])) {
    if($_SESSION['userID'] != 1) {
        header("Location: ../../../");
    } else {
        $userLoginResult = $mysqli->query("SELECT login from users WHERE id = '".$_SESSION['userID']."'");
        $userLogin = $userLoginResult->fetch_array(MYSQLI_NUM);
    }
} else {
    header("Location: ../../index.php");
}

if(!empty($_REQUEST['id'])) {
    $handleCheckResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."' AND category = '".HANDLES_CATEGORY."'");
    $handleCheck = $handleCheckResult->fetch_array(MYSQLI_NUM);

    if($handleCheck[0] == 0) {
        header("Location: index.php");
    }

    if(!empty($_REQUEST['type'])) {
        $typeCheckResult = $mysqli->query("SELECT COUNT(id) FROM handles_types WHERE id = '".$mysqli->real_escape_string($_REQUEST['type'])."'");
        $typeCheck = $typeCheckResult->fetch_array(MYSQLI_NUM);

        if($typeCheck[0] == 0) {
            header("Location: index.php?id=".$_REQUEST['id']);
        }
    }
}


?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        Установка фильтров ручек

        <?php
            if(!empty($_REQUEST['id'])) {
                $handleNameResult = $mysqli->query("SELECT name FROM catalogue_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                $handleName = $handleNameResult->fetch_array(MYSQLI_NUM);

                echo " | ".$handleName[0];
            }
        ?>
    </title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>
    <link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
    <script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
    <script type="text/javascript" src="/js/notify.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/admin/admin.js"></script>
    <script type="text/javascript" src="/js/admin/filters/set/index.js"></script>

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
        <div class="menuPoint">
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
    <a href="/admin/filters/">
        <div class="menuPointActive">
            <div class="menuIMG"><img src="/img/system/admin/filters.png" /></div>
            <div class="menuText">Фильтры</div>
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
    <div style="clear: both;"></div>
    <br />
    <div id="admContent">
        <br />
        <div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/filters.png" title="Фильтры" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="/admin/filters/"><span class="breadCrumbsText">Фильтры</span></a> > <a href="/admin/filters/materials/"><span class="breadCrumbsText">Материалы ручек</span></a> > <a href="/admin/filters/materials/edit.php"><span class="breadCrumbsText">Редактирование материалов ручек</span></a></div></div>
        <div style="clear: both;"></div>
        <br />
        <h2>
            Установка фильтров

            <?php
                if(!empty($handleName[0])) {
                    echo " ручки <span style='color: #ff282b;'>«".$handleName[0]."»</span>";
                } else {
                    echo " ручек";
                }
            ?>
        </h2>
        <a href="/admin/filters/brands/"><input type="button" class="button" id="brandButton" value="Бренды ручек" onmouseover="buttonChange('brandButton', 1)" onmouseout="buttonChange('brandButton', 0)" style="margin-left: 0;" /></a>
        <a href="/admin/filters/types/"><input type="button" class="button" id="typeButton" value="Типы ручек" onmouseover="buttonChange('typeButton', 1)" onmouseout="buttonChange('typeButton', 0)" /></a>
        <a href="/admin/filters/sizes/"><input type="button" class="button" id="sizeButton" value="Размеры ручек" onmouseover="buttonChange('sizeButton', 1)" onmouseout="buttonChange('sizeButton', 0)" /></a>
        <a href="/admin/filters/colors/"><input type="button" class="button" id="colorButton" value="Цвета ручек" onmouseover="buttonChange('colorButton', 1)" onmouseout="buttonChange('colorButton', 0)" /></a>
        <a href="/admin/filters/materials"><input type="button" class="button" id="materialButton" value="Материалы ручек" onmouseover="buttonChange('materialButton', 1)" onmouseout="buttonChange('materialButton', 0)" /></a>
        <a href="/admin/filters/set"><input type="button" class="buttonActive" value="Установка фильтров" /></a>
        <div style="clear: both;"></div>
        <br /><br />
        <form id="setForm" method="post">
            <label for="handleSelect">Выберите ручку:</label>
            <br />
            <select id="handleSelect" name="handle" onchange="window.location = 'index.php?id=' + this.options[this.selectedIndex].value">
                <option value="">- Выберите ручку -</option>
                <?php
                    $handleResult = $mysqli->query("SELECT * FROM catalogue_new WHERE category = '".HANDLES_CATEGORY."' ORDER BY name");
                    while ($handle = $handleResult->fetch_assoc()) {
                        $filterCheckResult = $mysqli->query("SELECT * FROM handles_specifications WHERE catalogue_id = '".$handle['id']."'");
                        echo "
                            <option value='".$handle['id']."'"; if($_REQUEST['id'] == $handle['id']) {echo " selected";} echo ">".$handle['name'];

                        if($filterCheckResult->num_rows > 0) {
                            echo " (ФИЛЬТРЫ УСТАНОВЛЕНЫ)";
                        }

                        echo "</option>";
                    }
                ?>
            </select>

            <?php
                if(!empty($_REQUEST['id'])) {
                    $handleResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                    $handle = $handleResult->fetch_assoc();

                    echo "
                        <br /><br />
                        <div class='catalogueItem'>
                            <div class='itemDescription'>
                                <table style='border: none; width: 100%;'>
                                    <tr>
                                        <td style='width: 100px;' valign='top'>
                                            <div class='catalogueIMG'>
                                                <a href='/img/catalogue/big/".$handle['picture']."' class='lightview' data-lightview-options=\"skin: 'light'\" data-lightview-options=\"skin: 'light'\" data-lightview-title='".$handle['name']."' data-lightview-caption='".nl2br(strip_tags($handle['description']))."'><img src='/img/catalogue/small/".$handle['small']."' /></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='catalogueInfo'>
                                                <div class='catalogueName'>
                                                    <div style='width: 5px; height: 30px; background-color: #ff282b; position: relative; float: left;'></div>
                                                    <div style='margin-left: 15px;'><a href='../../../catalogue/item.php?id=".$handle['id']."' target='_blank'><span class='catalogueNameLink'>".$handle['name']."</span></a></div>
                                                    <div style='clear: both;'></div>
                                                </div>
                                                <div class='catalogueDescription'>
                                                    <table style='width: 100%; border: none;'>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                    ";

                    $description = str_replace("\n", "", $handle['description']);
                    $strings = explode("<br />", $description);

                    for($i = 0; $i < count($strings); $i++) {
                        $string = explode(':', $strings[$i]);
                        if(count($string) > 1) {
                            for($j = 0; $j < count($string); $j++) {
                                if($j == 0) {
                                    echo "<b>".$string[$j].":</b>";
                                } else {
                                    if($j == (count($string) - 1)) {
                                        echo $string[$j];
                                    } else {
                                        echo $string[$j].":";
                                    }
                                }
                            }
                            echo "<br />";
                        } else {
                            echo $string[0]."<br />";
                        }
                    }

                    echo "

                                                                <br />
                                                                <div style='width: 100%; border-bottom: 1px dotted #d4d4d4;'></div>
                                                                <br />
                                                                <b>Артикул: </b>".$handle['code']."
                                                                <br />
                                                                <b>Наличие: </b>
                    ";

                    if($handle['quantity'] > 0) {echo "на складе";} else {echo "<span style='color: #870000;'>нет на складе</span>";}

                    echo "
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style='clear: both;'></div>
                                            </div>
                                            <div style='clear: both;'></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style='clear: both;'></div>
                        </div>
                        <div style='clear: both;'></div>
                    ";
                    $handleResult = $mysqli->query("SELECT * FROM handles_specifications WHERE catalogue_id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                    $handle = $handleResult->fetch_assoc();

                    if(!empty($handle)) {
                        //////////////////ЕСЛИ УСТАНОВЛЕНЫ ФИЛЬТРЫ//////////////////////

                        echo "
                        <br /><hr /><hr style='margin-top: -7px;' />
                        <br />
                        <label for='typeSelect'>Выберите тип:</label>
                        <br />
                        <select id='typeSelect' name='type'>
                    ";

                        $typeResult = $mysqli->query("SELECT * FROM handles_types ORDER BY name");
                        while ($type = $typeResult->fetch_assoc()) {
                            echo "<option value='".$type['id']."'"; if($type['id'] == $handle['type_id']) {echo " selected";} echo ">".$type['name']."</option>";
                        }

                        echo "</select>";

                        if($handle['type_id'] == HANDLES_SK or $handle['type_id'] == HANDLES_RE or $handle['type_id'] == HANDLES_TO or $handle['type_id'] == HANDLES_VS or $handle['type_id'] == HANDLES_KS or $handle['type_id']) {
                            echo "
                            <br /><br />
                            <label for='sizeSelect'>Выберите размер:</label>
                            <br />
                            <select id='sizeSelect' name='size'>
                                <option value=''>- Без размера -</option>
                        ";

                            $sizeResult = $mysqli->query("SELECT * FROM handles_sizes ORDER BY handle_size");
                            while($size = $sizeResult->fetch_assoc()) {
                                echo "<option value='".$size['id']."'"; if($size['id'] == $handle['size_id']) {echo " selected";} echo ">".$size['handle_size']."</option>";
                            }

                            echo "
                            </select>
                            
                            <br /><br />
                            <label for='materialSelect'>Выберите материал:</label>
                            <br />
                            <select id='materialSelect' name='material'>
                        ";

                            $materialResult = $mysqli->query("SELECT * FROM handles_materials ORDER BY name");
                            while ($material = $materialResult->fetch_assoc()) {
                                echo "<option value='".$material['id']."'"; if($material['id'] == $handle['material_id']) {echo " selected";} echo ">".$material['name']."</option>";
                            }

                            echo "
                            </select>
                            
                            <br /><br />
                            <label for='colorSelect'>Выберите цвет:</label>
                            <br />
                            <select id='colorSelect' name='color'>
                        ";

                            $colorResult = $mysqli->query("SELECT * FROM handles_colors ORDER BY name");
                            while($color = $colorResult->fetch_assoc()) {
                                echo "<option value='".$color['id']."'"; if($color['id'] == $handle['color_id']) {echo " selected";} echo ">".$color['name']."</option>";
                            }

                            echo "
                            </select>
                            
                            <br /><br />
                            <label for='brandSelect'>Выберите бренд:</label>
                            <br />
                            <select id='brandSelect' name='brand'>
                        ";

                            $brandResult = $mysqli->query("SELECT * FROM handles_brands ORDER BY name");
                            while($brand = $brandResult->fetch_assoc()) {
                                echo "<option value='".$brand['id']."'"; if($brand['id'] == $handle['brand_id']) {echo " selected";} echo ">".$brand['name']."</option>";
                            }

                            echo "
                            </select>
                            
                            <br /><br />
                            <input type='button' class='button' style='margin: 0' id='setFiltersButton' onmouseover='buttonChange(\"setFiltersButton\", 1)' onmouseout='buttonChange(\"setFiltersButton\", 0)' onclick='setFilters()' value='Установить' />
                        ";
                        }
                    }
                    else {
                        /////////////////ЕСЛИ НЕ УСТАНОВЛЕНЫ ФИЛЬТРЫ/////////////////////

                        echo "
                        <br /><hr /><hr style='margin-top: -7px;' />
                        <br />
                        <label for='typeSelect'>Выберите тип:</label>
                        <br />
                        <select id='typeSelect' name='type' onchange=\"window.location = 'index.php?id=".$_REQUEST['id']."&type=' + this.options[this.selectedIndex].value\">
                            <option value=''>- Выберите тип -</option>
                    ";

                        $typeResult = $mysqli->query("SELECT * FROM handles_types ORDER BY name");
                        while($type = $typeResult->fetch_assoc()) {
                            echo "<option value='".$type['id']."'"; if(!empty($_REQUEST['type']) and $_REQUEST['type'] == $type['id']) {echo " selected";} echo ">".$type['name']."</option>";
                        }

                        echo "</select>";

                        if(!empty($_REQUEST['type'])) {
                            if($_REQUEST['type'] == HANDLES_SK or $_REQUEST['type'] == HANDLES_RE or $_REQUEST['type'] == HANDLES_TO or $_REQUEST['type'] == HANDLES_VS or $_REQUEST['type'] == HANDLES_KS) {
                                ///////ВЫВОД ФИЛЬТРОВ ДЛЯ РУЧЕК С ПРИСАДОЧНЫМ РАЗМЕРОМ///////

                                echo "
                                    <br /><br />
                                    <label for='sizeSelect'>Выберите размер:</label>
                                    <br />
                                    <select id='sizeSelect' name='size'>
                                        <option value=''>- Выберите размер -</option>
                                ";

                                $sizeResult = $mysqli->query("SELECT * FROM handles_sizes ORDER BY handle_size");
                                while($size = $sizeResult->fetch_assoc()) {
                                    echo "<option value='".$size['id']."'>".$size['handle_size']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <label for='materialSelect'>Выберите материал:</label>
                                    <br />
                                    <select id='materialSelect' name='material'>
                                        <option value=''>- Выберите материал -</option>
                                ";

                                $materialResult = $mysqli->query("SELECT * FROM handles_materials ORDER BY name");
                                while($material = $materialResult->fetch_assoc()) {
                                    echo "<option value='".$material['id']."'>".$material['name']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <label for='colorSelect'>Выберите цвет:</label>
                                    <br />
                                    <select id='colorSelect' name='color'>
                                        <option value=''>- Выберите цвет -</option>
                                ";

                                $colorResult = $mysqli->query("SELECT * FROM handles_colors ORDER BY name");
                                while($color = $colorResult->fetch_assoc()) {
                                    echo "<option value='".$color['id']."'>".$color['name']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <label for='brandSelect'>Выберите бренд:</label>
                                    <br />
                                    <select id='brandSelect' name='brand'>
                                        <option value=''>- Выберите бренд -</option>
                                ";

                                $brandResult = $mysqli->query("SELECT * FROM handles_brands ORDER BY name");

                                while ($brand = $brandResult->fetch_assoc()) {
                                    echo "<option value='".$brand['id']."'>".$brand['name']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <input type='button' class='button' style='margin: 0' id='setFiltersButton' onmouseover='buttonChange(\"setFiltersButton\", 1)' onmouseout='buttonChange(\"setFiltersButton\", 0)' onclick='setNewFiltersWithSize()' value='Установить' />
                                ";
                            } else {
                                ///////ВЫВОД ФИЛЬТРОВ ДЛЯ РУЧЕК БЕЗ ПРИСАДОЧНОГО РАЗМЕРА///////

                                echo "
                                    </select>
                                    <br /><br />
                                    <label for='materialSelect'>Выберите материал:</label>
                                    <br />
                                    <select id='materialSelect' name='material'>
                                        <option value=''>- Выберите материал -</option>
                                ";

                                $materialResult = $mysqli->query("SELECT * FROM handles_materials ORDER BY name");
                                while($material = $materialResult->fetch_assoc()) {
                                    echo "<option value='".$material['id']."'>".$material['name']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <label for='colorSelect'>Выберите цвет:</label>
                                    <br />
                                    <select id='colorSelect' name='color'>
                                        <option value=''>- Выберите цвет -</option>
                                ";

                                $colorResult = $mysqli->query("SELECT * FROM handles_colors ORDER BY name");
                                while($color = $colorResult->fetch_assoc()) {
                                    echo "<option value='".$color['id']."'>".$color['name']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <label for='brandSelect'>Выберите бренд:</label>
                                    <br />
                                    <select id='brandSelect' name='brand'>
                                        <option value=''>- Выберите бренд -</option>
                                ";

                                $brandResult = $mysqli->query("SELECT * FROM handles_brands ORDER BY name");

                                while ($brand = $brandResult->fetch_assoc()) {
                                    echo "<option value='".$brand['id']."'>".$brand['name']."</option>";
                                }

                                echo "
                                    </select>
                                    <br /><br />
                                    <input type='button' class='button' style='margin: 0' id='setFiltersButton' onmouseover='buttonChange(\"setFiltersButton\", 1)' onmouseout='buttonChange(\"setFiltersButton\", 0)' onclick='setNewFiltersWithoutSize()' value='Установить' />
                                ";
                            }
                        }
                    }
                }
            ?>
        </form>
        <div style="clear: both;"></div>
    </div>
    <div style="clear: both;"></div>
</div>

<div style="clear: both;"></div>

</body>

</html>