<?php

include("connect.php");

$query = $mysqli->real_escape_string($_POST['query']);

$searchResult = $mysqli->query("SELECT * FROM catalogue_new WHERE name LIKE '%".$query."%' OR code LIKE '%".$query."%' LIMIT 10");
if($searchResult->num_rows == 0) {
	echo "<i>К сожалению, поиск не дал результата.</i>";
} else {
	$i = 0;
	while($search = $searchResult->fetch_assoc()) {
		$i++;
		echo "
			<div class='searchItem'"; if($i % 2 == 0) {echo " style='background-color: #d9d9d9;'";} echo ">
				<div class='searchIMG'>
					<a href='img/catalogue/big/".$search['picture']."' class='lightview' data-lightview-title='".$search['name']."' data-lightview-caption='".nl2br(strip_tags($search['description']))."'><img src='img/catalogue/small/".$search['small']."' /></a>
				</div>
				<div class='searchInfo'>

				</div>
				<div style='clear: both;'></div>
			</div>
			<div style='clear: both;'></div>
		";
	}
}