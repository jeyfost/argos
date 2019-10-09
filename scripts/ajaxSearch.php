<?php

session_start();
include("connect.php");

$query = $mysqli->real_escape_string($_POST['query']);

$searchResult = $mysqli->query("SELECT * FROM catalogue_new WHERE name LIKE '%".$query."%' OR code LIKE '%".$query."%' OR description LIKE '%".$query."%' ORDER BY name LIMIT 10");

if($searchResult->num_rows == 0) {
	echo "<i>К сожалению, поиск не дал результата.</i>";
} else {
	$j = 0;

	while($search = $searchResult->fetch_assoc()) {
		$j++;
		$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$search['unit']."'");
		$unit = $unitResult->fetch_assoc();

		echo $search['price'];

		if($search['price'] == 0 or $search['price'] == null) {
		    $price = " по запросу";
        } else {
            $rateResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$search['currency']."'");
            $rate = $rateResult->fetch_array(MYSQLI_NUM);

            $price = $search['price'] * $rate[0];

            if(isset($_SESSION['userID']) and $_SESSION['userID'] != 1) {
                $discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
                $discount = $discountResult->fetch_array(MYSQLI_NUM);

                $price = $price * (1 - $discount[0] / 100);
            }

            $roubles = floor($price);
            $kopeck = round(($price - $roubles) * 100);

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
        }

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
			<div class='searchItem'"; if($j % 2 == 0) {echo " style='background-color: #d9d9d9;'";} echo ">
				<div class='searchIMG'>
					<a href='/img/catalogue/big/".$search['picture']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-title='".$search['name']."' data-lightview-caption='".nl2br(strip_tags($search['description']))."'><img src='/img/catalogue/small/".$search['small']."' /></a>
				</div>
				<div class='searchInfo'>
					<span style='font-size: 18px; font-style: italic;'><a href='/catalogue/item.php?id=".$search['id']."' class='catalogueNameLink'>".$search['name']."</a></span>
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
					<b>Стоимость за ".$unit['short_name'].": </b>".$price."
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