<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 22.03.2017
 * Time: 15:20
 */

include("../../connect.php");

$query = $mysqli->real_escape_string($_POST['search']);

$searchResult = $mysqli->query("SELECT * FROM catalogue_new WHERE name LIKE '%".$query."%' OR code LIKE '%".$query."%' OR description LIKE '%".$query."%'  ORDER BY name LIMIT 10 ");

if($searchResult->num_rows > 0) {
	$j = 0;
	while($search = $searchResult->fetch_assoc()) {
        $actionIDResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$search['id']."'");

        if($actionIDResult->num_rows > 0) {
            while($actionID = $actionIDResult->fetch_assoc()) {
                $actionResult = $mysqli->query("SELECT * FROM actions WHERE id = '".$actionID['action_id']."'");
                $action = $actionResult->fetch_assoc();
                $from = strtotime($action['from_date']);
                $to = strtotime($action['to_date']);
                $today = strtotime(date('d-m-Y'));

                if($today >= $from and $today <= $to) {
                    $active = 1;
                }
            }
        }

        if($active == 0) {
            $j++;

            $unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$search['unit']."'");
            $unit = $unitResult->fetch_assoc();
            $rateResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$search['currency']."'");
            $rate = $rateResult->fetch_array(MYSQLI_NUM);

            $price = $search['price'] * $rate[0];
            $price_opt = $search['price_opt'] * $rate[0];

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

            $roubles = floor($price_opt);
            $kopeck = ceil(($price_opt - $roubles) * 100);

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

            $price_opt = $roubles." руб. ".$kopeck." коп.";

            $typeResult = $mysqli->query("SELECT type_name FROM types WHERE catalogue_type = '".$search['type']."'");
            $type = $typeResult->fetch_array(MYSQLI_NUM);
            $categoryResult = $mysqli->query("SELECT name FROM categories_new WHERE id = '".$search['category']."'");
            $category = $categoryResult->fetch_array(MYSQLI_NUM);

            if(!empty($search['subcategory'])) {
                $subcategoryResult = $mysqli->query("SELECT name FROM subcategories_new WHERE id = '".$search['subcategory']."'");
                $subcategory = $subcategoryResult->fetch_array(MYSQLI_NUM);
            }

            if(!empty($search['subcategory2'])) {
                $subcategory2Result = $mysqli->query("SELECT name FROM subcategories2 WHERE id = '".$search['subcategory2']."'");
                $subcategory2 = $subcategory2Result->fetch_array(MYSQLI_NUM);
            }

            echo "
                <div class='searchItem'"; if($j % 2 == 0) {echo " style='background-color: #d9d9d9;'";} echo " onclick='chooseGood(\"".$search['id']."\", \"g_".substr($_POST['id'], 7)."\")'>
                    <div class='searchIMG'>
                        <a href='/img/catalogue/big/".$search['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$search['name']."' data-lightview-caption='".nl2br(strip_tags($search['description']))."'><img src='/img/catalogue/small/".$search['small']."' /></a>
                    </div>
                    <div class='searchInfo'>
                        <span style='font-size: 18px; font-style: italic;'>".$search['name']."</span>
                        <br />
                        <span style='font-size: 14px; font-style: italic;'><a href='/catalogue/index.php?type=".$search['type']."&p=1' class='searchLink'>".$type[0]."</a> > <a href='/catalogue/index.php?type=".$search['type']."&c=".$search['category']."&p=1' class='searchLink'>".$category[0]."</a>"; if(!empty($search['subcategory'])) {echo " > <a href='/catalogue/index.php?type=".$search['type']."&c=".$search['category']."&s=".$search['subcategory']."&p=1' class='searchLink'>".$subcategory[0]."</a>";} if(!empty($search['subcategory2'])) {echo " > <a href='/catalogue/index.php?type=".$search['type']."&c=".$search['category']."&s=".$search['subcategory']."&s2=".$search['subcategory2']."&p=1' class='searchLink'>".$subcategory2[0]."</a>";} echo "</span>
                        <br /><br />
		    ";

            $strings = explode("<br />", $search['description']);
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
					<b>Артикул: </b>".$search['code']."
					<br />
					<b>Цена розничная за ".$unit['short_name'].": </b>".$price."
					<br />
					<b>Цена оптовая за ".$unit['short_name'].": </b>".$price_opt."
		    ";

            if($search['sketch'] != '') {
                echo "<br /><br /><a href='/img/catalogue/sketch/".$search['sketch']."' class='lightview' data-lightview-options='skin: \"light\"'><span class='sketchFont'>Чертёж</span></a>";
            }

            echo "
                        <br /><br />
                    </div>
                    <div style='clear: both;'></div>
                </div>
                <div style='clear: both;'></div>
		    ";
        }
	}

	if($j == 0) {
        echo "<i>Выбранный вами товар уже участвует в акции.</i>";
    }
} else {
	echo "<i>К сожалению, поиск не дал результата.</i>";
}