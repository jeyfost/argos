<?php

include("connect.php");

$query = $mysqli->real_escape_string($_POST['query']);

$searchResult = $mysqli->query("SELECT * FROM catalogue_new WHERE name LIKE '%".$query."%' OR code LIKE '%".$query."%' ORDER BY name LIMIT 10");
if($searchResult->num_rows == 0) {
	echo "<i>К сожалению, поиск не дал результата.</i>";
} else {
	$j = 0;
	while($search = $searchResult->fetch_assoc()) {
		$j++;
		$unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$search['unit']."'");
		$unit = $unitResult->fetch_assoc();
		$rateResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$search['currency']."'");
		$rate = $rateResult->fetch_array(MYSQLI_NUM);

		$price = round(($search['price'] * $rate[0]), 2, PHP_ROUND_HALF_UP);
		$roubles = floor($price);
		$kopeck = ($price - $roubles) * 100;

		if($roubles == 0) {
			$price = $kopeck." коп.";
		} else {
			$price = $roubles." руб. ".$kopeck." коп.";
		}

		echo "
			<div class='searchItem'"; if($j % 2 == 0) {echo " style='background-color: #d9d9d9;'";} echo ">
				<div class='searchIMG'>
					<a href='img/catalogue/big/".$search['picture']."' class='lightview' data-lightview-title='".$search['name']."' data-lightview-caption='".nl2br(strip_tags($search['description']))."'><img src='img/catalogue/small/".$search['small']."' /></a>
				</div>
				<div class='searchInfo'>
					<span style='font-size: 18px; font-style: italic;'>".$search['name']."</span>
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
			echo "<br /><br /><a href='img/catalogue/sketch/".$search['sketch']."' class='lightview'><span class='sketchFont'>Чертёж</span></a>";
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