<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 19.02.2020
 * Time: 12:37
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$user_id = $mysqli->real_escape_string($_POST['user_id']);
$order_id = $mysqli->real_escape_string($_POST['order_id']);
$randomID = substr($mysqli->real_escape_string($_POST['block']), 2);

$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM orders WHERE order_id = '".$order_id."' AND good_id = '".$id."'");
$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

if($goodCheck[0] > 0) {
    echo "duplicate";
} else {
    $goodResult = $mysqli->query("SELECT * FROM catalogue_new WHERE id = '".$id."'");
    $good = $goodResult->fetch_assoc();
    $unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$good['unit']."'");
    $unit = $unitResult->fetch_assoc();
    $currencyResult = $mysqli->query("SELECT * FROM currency WHERE id = '".$good['currency']."'");
    $currency = $currencyResult->fetch_assoc();

    $userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$user_id."'");
    $user = $userResult->fetch_assoc();

    $active = 0;

    $actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$id."'");
    if($actionIDResult->num_rows > 0) {
        while($actionID = $actionIDResult->fetch_assoc()) {
            $actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID['action_id']."'");
            $action = $actionResult->fetch_assoc();
            $from = strtotime($action['from_date']);
            $to = strtotime($action['to_date']);
            $today = strtotime(date('d-m-Y'));

            if($today >= $from and $today <= $to) {
                $active = 1;
                $aID = $action['id'];
            }
        }
    }

    if($active == 0) {
        if($user['opt'] = 1) {
            $price = $good['price_opt'];
        } else {
            $price = $good['price'];
        }

        $price = $price * $currency['rate'];
        $price = $price - $price * ($user['discount'] / 100);
    } else {
        $actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$id."' AND action_id = '".$aID."'");
        $actionGood = $actionGoodResult->fetch_assoc();

        $price = $actionGood['price'] * $currency['rate'];
    }

    $roubles = floor($price);
    $kopeck = ceil(($price - $roubles) * 100);

    if($kopeck == 100) {
        $kopeck = 0;
        $roubles ++;
    }

    if($roubles == 0 and $kopeck == 0) {
        $kopeck = 1;
    }

    $kopeck = ceil($kopeck);

    if(strlen($kopeck) == 1) {
        $kopeck = "0".$kopeck;
    }

    $price = $roubles." руб. ".$kopeck." коп.";

    $today = strtotime(date('d-m-Y'));
    $actionCount = 0;
    $status = "<br /><br /><b>Товар принимает участие в следущих акциях:</b> ";

    $goodActionResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$good['id']."'");
    while($goodAction = $goodActionResult->fetch_assoc()) {
        $actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$goodAction['action_id']."'");

        while($action = $actionResult->fetch_assoc())
        {
            if(strtotime($action['from_date']) >= $today or (strtotime($action['from_date']) < $today and strtotime($action['to_date']) >= $today)) {
                $actionCount++;
                $status .= "c <span style='color: #ff282b;'>".$action['from_date']."</span> по <span style='color: #ff282b;'>".$action['to_date']."</span>; ";
            }
        }
    }

    if($actionCount > 0) {
        $status = substr($status, 0 , strlen($status) - 2).".";
    } else {
        $status = "";
    }

    echo "
        <br />
        <div class='goodImg'>
            <a href='/img/catalogue/big/".$good['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$good['name']."' data-lightview-caption='".nl2br(strip_tags($good['description']))."'><img src='/img/catalogue/small/".$good['small']."' /></a>
    ";

    if($actionCount > 0) {
        echo "<img src='/img/system/action.png' class='actionIMGSearch' />";
    }

    echo "
        </div>
        <div class='goodInfo'>
            <div class='goodName'>
                <div style='width: 5px; height: 30px; background-color: #ff282b; position: relative; float: left;'></div>
                <div style='margin-left: 15px;'>".$good['name']."</div>
                <div style='clear: both;'></div>
            </div>
            <div class='goodDescription'>
    ";

    $description = str_replace("\n", "<br />", $good['description']);
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

    if($user['opt'] == 1) {
        $priceType = "оптовые";
    } else {
        $priceType = "розничные";
    }

    echo "
			<br />
			<b>Артикул: </b>".$good['code']."
			<br />
			<span><b>Цены клиента: </b>".$priceType."</span>
			<br />
    ";

    if($user['discount'] > 0) {
        echo "
            <span><b>Дополнительная скидка клиента: </b>".$user['discount']."%</span>
            <br />
        ";
    }

    if($actionCount > 0) {
        echo "<span><b>Акционная цена за ".$unit['for_name'].": <span style='color: #ff282b;'>".$price."</span></b></span>";
    } else {
        echo "<span><b>Цена клиента за ".$unit['for_name']; if($user['discount'] > 0) {echo " с учётом дополнительной скидки";} echo ": </b></span>".$price."</span>";
    }

    echo "
			".$status."
			<br /><br >
			<label for='np_".$randomID."'><b>Количество:</b></label>
			<br />
			<input type='number' min='1' step='1' class='actionGoodPrice' id='np_".$randomID."' value='1' onkeyup='recalculatePriceFromInput(\"".$id."\", \"".$user_id."\", \"".$order_id."\", \"np_".$randomID."\")' onchange='recalculatePriceFromInput(\"".$id."\", \"".$user_id."\", \"".$order_id."\", \"np_".$randomID."\")' onblur='checkQuantity(\"np_".$randomID."\", \"".$order_id."\", \"".$user_id."\", \"".$id."\")' />
    ";

    if($good['sketch'] != '') {
        echo "<br /><br /><a href='/img/catalogue/sketch/".$good['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
    }

    echo "
		</div>
		<div style='clear: both;'></div>
    ";
}