<?php

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

$emailCountResult = $mysqli->query("SELECT COUNT(id) FROM mail_result");
$emailCount = $emailCountResult->fetch_array(MYSQLI_NUM);

if($emailCount[0] > 10) {
    if($emailCount[0] % 10 == 0) {
        $numbers = intval($emailCount[0] / 10);
    } else {
        $numbers = intval($emailCount[0] / 10) + 1;
    }
} else {
    $numbers = 1;
}

if(empty($_REQUEST['p'])) {
    if(empty($_REQUEST['id'])) {
        header("Location: history.php?p=1");
    }
} else {
    if($_REQUEST['p'] < 1 or $_REQUEST['p'] > $numbers) {
        $link = "history.php";

        header("Location: ".$link);
    }
}

if(!empty($_REQUEST['id'])) {
	$checkResult = $mysqli->query("SELECT COUNT(id) FROM mail_result WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
	$check = $checkResult->fetch_array(MYSQLI_NUM);

	if($check[0] == 0) {
		header("Location: history.php");
	}
}

if(!empty($_REQUEST['p'])) {
    $page = $mysqli->real_escape_string($_REQUEST['p']);
} else {
    $page = 1;
}

$start = intval($page) * 10 - 10;

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>История email-рассылок</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/js/notify.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/md5.js"></script>
	<script type="text/javascript" src="/js/admin/admin.js"></script>

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
			<div class="menuPointActive">
				<div class="menuIMG"><img src="/img/system/admin/mail.png" /></div>
				<div class="menuText">Email-рассылки</div>
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
			<div id="breadCrumbs"><div id="breadCrumbsIcon"><img src="/img/system/admin/icons/mail.png" title="Email-рассылки" /></div><div id="breadCrumbsTextContainer"><a href="/admin/admin.php"><span class="breadCrumbsText">Панель администрирования</span></a> > <a href="index.php"><span class="breadCrumbsText">Email-рассылки</span></a> > <a href="history.php"><span class="breadCrumbsText">История email-рассылок</span></a></div></div>
			<div style="clear: both;"></div>
			<br />
			<h2>История email-рассылок</h2>
			<a href="send.php"><input type="button" class="button" id="sendButton" value="Отправление" style="margin-left: 0;" onmouseover="buttonChange('sendButton', 1)" onmouseout="buttonChange('sendButton', 0)" /></a>
			<a href="history.php"><input type="button" class="buttonActive" id="historyButton" value="История" /></a>
			<div style="clear: both;"></div>
			<br /><br />
			<div id="goodsTable" <?php if(!empty($_REQUEST['id'])) {echo "style='display: none;'";} ?>>
				<?php
					if(empty($_REQUEST['id'])) {
						//Таблица с историей рассылок
						$historyCountResult = $mysqli->query("SELECT COUNT(id) FROM mail_result");
						$historyCount = $historyCountResult->fetch_array(MYSQLI_NUM);

						$historyResult = $mysqli->query("SELECT * FROM mail_result ORDER BY date DESC LIMIT ".$start.", 10");

						echo "
							<span>Выберите рассылку для детализации:</span>
							<br />
							<span style='font-size: 14px;'><b>Всего рассылок отправлено: </b>".$historyCount[0]."</span>
							<br /><br />
							<table style='text-align: center;'>
								<tr>
									<td style='font-weight: bold; background-color: #ededed;'>№</td>
									<td style='font-weight: bold; background-color: #ededed;'>Дата</td>
									<td style='font-weight: bold; background-color: #ededed;'>Тема</td>
									<td style='font-weight: bold; background-color: #ededed;'>Получатель</td>
									<td style='font-weight: bold; background-color: #ededed;'>Кол-во отправленных писем</td>
									<td style='font-weight: bold; background-color: #ededed;'>Кол-во доставленных писем</td>
									<td style='font-weight: bold; background-color: #ededed;'>Файлы</td>
								</tr>
						";

						$j = 0;

						while($history = $historyResult->fetch_assoc()) {
							$j++;
							$link = "history.php?id=".$history['id'];
							$sendTo = "";

							if(substr($history['send_to'], 0, 8) == "district" and substr($history['send_to'], 10, 1) == ":") {
								//если отправлено по обалсти
								$district = substr($history['send_to'], 9, 1);
								$locationResult = $mysqli->query("SELECT * FROM locations WHERE id = '".$district."'");
								$location = $locationResult->fetch_assoc();

								$sendTo .= "<b>".$location['name']." область</b>. Получатели:<br /><br />";

								$to = substr($history['send_to'], 12);
								$client = explode(";", $to);

								for($i= 0; $i < count($client); $i++) {
									$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
									$c = $cResult->fetch_assoc();

									if(!empty($c['name'])) {
										$sendTo .= $c['name'];
									} else {
										$sendTo .= $c['email'];
									}

									if($i < count($client) - 1) {
										$sendTo .= "<br /><hr />";
									}
								}
							} elseif(filter_var($history['send_to'], FILTER_VALIDATE_EMAIL)) {
								//если отправлено по одному адресу

								$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE email = '".$history['send_to']."'");
								$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

								if($emailCheck[0] > 0) {
									$clientResult = $mysqli->query("SELECT * FROM clients WHERE email = '".$history['send_to']."'");
									$client = $clientResult->fetch_assoc();

									$sendTo = $client['name'];
								} else {
									$sendTo = $history['send_to'];
								}
							} else {
								$client = explode(';', $history['send_to']);

								for($i= 0; $i < count($client); $i++) {
									$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
									$c = $cResult->fetch_assoc();

									if(!empty($c['name'])) {
										$sendTo .= $c['name'];
									} else {
										$sendTo .= $c['email'];
									}

									if($i < count($client) - 1) {
										$sendTo .= "<br /><hr />";
									}
								}
							}

							if($history['files_count'] > 0) {
								$files = "";
								$file = explode(';', $history['filenames']);

								for($i = 0; $i < count($file); $i++) {
									$files .= $file[$i];

									if($i < count($file) - 1) {
										$files .= "<br />";
									}
								}
							} else {
								$files = $history['filenames'];
							}

							if($files == '') {
								$files = "Файлов нет";
							}

							$date = (int)substr($history['date'], 8, 2)." ";

							switch(substr($history['date'], 5, 2)) {
								case "01":
									$date .= "января";
									break;
								case "02":
									$date .= "февраля";
									break;
								case "03":
									$date .= "марта";
									break;
								case "04":
									$date .= "апреля";
									break;
								case "05":
									$date .= "мая";
									break;
								case "06":
									$date .= "июня";
									break;
								case "07":
									$date .= "июля";
									break;
								case "08":
									$date .= "агуста";
									break;
								case "09":
									$date .= "сентября";
									break;
								case "10":
									$date .= "октября";
									break;
								case "11":
									$date .= "ноября";
									break;
								case "12":
									$date .= "декабря";
									break;
								default: break;
							}

							$date .= " ".substr($history['date'], 0, 4)." г. в ".substr($history['date'], 11);

							echo "
								<tr>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} else {echo "#ededed";} echo ";'>".($page * 10 - 10 + $j)."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$date."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'><a href='".$link."'><span class='link'>".$history['subject']."</span></a></td>
									<td style='text-align: left; background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$sendTo."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$history['count']."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$history['send']."</td>
									<td style='background-color: "; if($_REQUEST['id'] == $history['id']) {echo "#cbd7ff";} elseif($j % 2 != 0) {echo "#fff";} else {echo "#ededed";} echo ";'>".$files."</td>
								</tr>
							";
						}

						echo "
							</table>
						";
					}
				?>
			</div>
            <?php
                if(empty($_REQUEST['id'])) {
                    echo "<div id='pageNumbers'>";

                    if($numbers > 1) {
                        $uri = explode("&p=", $_SERVER['REQUEST_URI']);
                        $link = $uri[0]."&p=";
                        if($numbers <= 7) {
                            echo "<br /><br />";

                            if($_REQUEST['p'] == 1) {
                                echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
                            } else {
                                echo "<a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>";
                            }

                            for($i = 1; $i <= $numbers; $i++) {
                                if($_REQUEST['p'] != $i) {
                                    echo "<a href='".$link.$i."'>";
                                }

                                echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

                                if($_REQUEST['p'] != $i) {
                                    echo "</a>";
                                }
                            }

                            if($_REQUEST['p'] == $numbers) {
                                echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
                            } else {
                                echo "<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
                            }

                            echo "</div>";

                        } else {
                            if($_REQUEST['p'] < 5) {
                                if($_REQUEST['p'] == 1) {
                                    echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";
                                } else {
                                    echo "<a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>";
                                }

                                for($i = 1; $i <= 5; $i++) {
                                    if($_REQUEST['p'] != $i) {
                                        echo "<a href='".$link.$i."'>";
                                    }

                                    echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

                                    if($_REQUEST['p'] != $i) {
                                        echo "</a>";
                                    }
                                }

                                echo "<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
                                echo "<a href='".$link.$numbers."'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>";

                                if($_REQUEST['p'] == $numbers) {
                                    echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
                                } else {
                                    echo "<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
                                }

                                echo "</div>";
                            } else {
                                $check = $numbers - 3;

                                if($_REQUEST['p'] >= 5 and $_REQUEST['p'] < $check) {
                                    echo "
                                            <br /><br />
                                            <div id='pageNumbers'>
                                                <a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>
                                                <a href='".$link."1'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='goodStyleRed' id='pbt1'>1</span></div></a>
                                                <div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
                                                <a href='".$link.($_REQUEST['p'] - 1)."'><div id='pb".($_REQUEST['p'] - 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($_REQUEST['p'] - 1)."\", \"pbt".($_REQUEST['p'] - 1)."\")' onmouseout='pageBlock(0, \"pb".($_REQUEST['p'] - 1)."\", \"pbt".($_REQUEST['p'] - 1)."\")'><span class='goodStyleRed' id='pbt".($_REQUEST['p'] - 1)."'>".($_REQUEST['p'] - 1)."</span></div></a>
                                                <div class='pageNumberBlockActive'><span class='goodStyleWhite'>".$_REQUEST['p']."</span></div>
                                                <a href='".$link.($_REQUEST['p'] + 1)."'><div id='pb".($_REQUEST['p'] + 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($_REQUEST['p'] + 1)."\", \"pbt".($_REQUEST['p'] + 1)."\")' onmouseout='pageBlock(0, \"pb".($_REQUEST['p'] + 1)."\", \"pbt".($_REQUEST['p'] + 1)."\")'><span class='goodStyleRed' id='pbt".($_REQUEST['p'] + 1)."'>".($_REQUEST['p'] + 1)."</span></div></a>
                                                <div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
                                                <a href='".$link.$numbers."'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div></a>
                                                <a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>
                                            </div>
                                        ";
                                } else {
                                    echo "
                                            <br /><br />
                                            <div id='pageNumbers'>
                                                <a href='".$link.($_REQUEST['p'] - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div></a>
                                                <a href='".$link."1'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='goodStyleRed' id='pbt1'>1</span></div></a>
                                                <div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
                                        ";

                                    for($i = ($numbers - 4); $i <= $numbers; $i++) {
                                        if($_REQUEST['p'] != $i) {
                                            echo "<a href='".$link.$i."'>";
                                        }

                                        echo "<div id='pb".$i."' "; if($i == $_REQUEST['p']) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $_REQUEST['p']) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";

                                        if($_REQUEST['p'] != $i) {
                                            echo "</a>";
                                        }
                                    }

                                    if($_REQUEST['p'] == $numbers) {
                                        echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
                                    } else {
                                        echo "<a href='".$link.($_REQUEST['p'] + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";
                                    }
                                }
                            }
                        }
                    }

                    echo "<div style='clear: both;'></div>";
                }
            ?>
			<?php
				if(!empty($_REQUEST['id'])) {
					//Детализация письма
					$id = $mysqli->real_escape_string($_REQUEST['id']);

					$historyResult = $mysqli->query("SELECT * FROM mail_result WHERE id = '".$id."'");
					$history = $historyResult->fetch_assoc();

					if(substr($history['send_to'], 0, 8) == "district" and substr($history['send_to'], 10, 1) == ":") {
						//если отправлено по обалсти
						$district = substr($history['send_to'], 9, 1);
						$locationResult = $mysqli->query("SELECT * FROM locations WHERE id = '".$district."'");
						$location = $locationResult->fetch_assoc();

						$to = substr($history['send_to'], 12);
						$client = explode(";", $to);

						for($i= 0; $i < count($client); $i++) {
							$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
							$c = $cResult->fetch_assoc();

							$sendTo .= $c['name'];

							if($i < count($client) - 1) {
								$sendTo .= "; ";
							}
						}
					} elseif(filter_var($history['send_to'], FILTER_VALIDATE_EMAIL)) {
						//если отправлено по одному адресу

						$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE email = '".$history['send_to']."'");
						$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

						if($emailCheck[0] > 0) {
							$clientResult = $mysqli->query("SELECT * FROM clients WHERE email = '".$history['send_to']."'");
							$client = $clientResult->fetch_assoc();

							$sendTo = $client['name'];
						} else {
							$sendTo = $history['send_to'];
						}
					} else {
						$client = explode(';', $history['send_to']);

						for($i= 0; $i < count($client); $i++) {
							$cResult = $mysqli->query("SELECT * FROM clients WHERE id = '".$client[$i]."'");
							$c = $cResult->fetch_assoc();

							$sendTo .= $c['name'];

							if($i < count($client) - 1) {
								$sendTo .= "; ";
							}
						}
					}

					if($history['files_count'] > 0) {
						$files = "";
						$file = explode(';', $history['filenames']);

						for($i = 0; $i < count($file); $i++) {
							$files .= $file[$i];

							if($i < count($file) - 1) {
								$files .= "; ";
							}
						}
					} else {
						$files = $history['filenames'];
					}

					if($files == '') {
						$files = "Файлов нет";
					}

					$date = (int)substr($history['date'], 8, 2)." ";

					switch(substr($history['date'], 5, 2)) {
						case "01":
							$date .= "января";
							break;
						case "02":
							$date .= "февраля";
							break;
						case "03":
							$date .= "марта";
							break;
						case "04":
							$date .= "апреля";
							break;
						case "05":
							$date .= "мая";
							break;
						case "06":
							$date .= "июня";
							break;
						case "07":
							$date .= "июля";
							break;
						case "08":
							$date .= "агуста";
							break;
						case "09":
							$date .= "сентября";
							break;
						case "10":
							$date .= "октября";
							break;
						case "11":
							$date .= "ноября";
							break;
						case "12":
							$date .= "декабря";
							break;
						default: break;
					}

					$date .= " ".substr($history['date'], 0, 4)." г. в ".substr($history['date'], 11);

					echo "
						<a href='history.php'><span class='redLink' style='font-style: italic; font-size: 14px;'>Вернуться к истории рассылок</span></a>
						<h3>".$history['subject']."</h3>
						<span style='font-style: italic; font-weight: bold;'>Дата отправления: <span style='font-weight: normal;'>".$date."</span></span>
						<br />
						<span style='font-style: italic; font-weight: bold;'>Получатели: <span style='font-weight: normal;'>".$sendTo."</span></span>
						<br /><br />
						<hr />
						".$history['text']."
						<hr />
					";

					if($history['files_count'] > 0) {
						echo "
							<br />
							<span style='font-style: italic; font-weight: bold;'>Количество прикреплённых файлов: <span style='font-weight: normal;'>".$history['files_count']."</span></span>
							<br />
							<span style='font-style: italic; font-weight: bold;'>Файлы: <span style='font-weight: normal;'>".$files."</span></span>
						";
					}

					echo "
						<br /><br />
						<a href='history.php'><span class='redLink' style='font-style: italic; font-size: 14px;'>Вернуться к истории рассылок</span></a>
					";
				}
			?>
			<div style="clear: both;"></div>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 100%; height: 40px;"></div>
	</div>
	<div style="clear: both;"></div>

	<script type="text/javascript">
		CKEDITOR.replace("text");
	</script>

</body>

</html>