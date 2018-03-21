<?php

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['client']);

if($id == "all") {
	$quantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '1'");
} else {
	$quantityResult = $mysqli->query("SELECT COUNT(id) FROM orders_info WHERE status = '1' AND user_id = '".$id."'");
}

$quantity = $quantityResult->fetch_array(MYSQLI_NUM);

if($quantity[0] > 10) {
	if($quantity[0] % 10 != 0) {
		$numbers = intval(($quantity[0] / 10) + 1);
	} else {
		$numbers = intval($quantity[0] / 10);
	}
} else {
	$numbers = 1;
}

if($numbers > 1) {
	if($numbers <= 7) {
		echo "<br /><br /><div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";

		for($i = 1; $i <= $numbers; $i++) {
			echo "<div id='pb".$i."' "; if($i == 1) {echo "class='pageNumberBlockActive' style='cursor: default;'";} else {echo "class='pageNumberBlock' style='cursor: pointer;' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")' onclick='goToPage(\"".$i."\", \"".$id."\")'";} echo "><span "; if($i == 1) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";
		}

		echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: pointer;' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")' onclick='goToPage(\"2\", \"".$id."\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div>";
	} else {
		echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>Предыдущая</span></div>";

		for($i = 1; $i <= 5; $i++) {
			echo "<div id='pb".$i."' "; if($i == 1) {echo "class='pageNumberBlockActive' style='cursor: default;'";} else {echo "class='pageNumberBlock' style='cursor: pointer;' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")' onclick='goToPage(\"".$i."\", \"".$id."\")'";} echo "><span "; if($i == 1) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";
		}

		echo "<div class='pageNumberBlock' style='cursor: url(\"/img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
		echo "<div id='pb".$numbers."' class='pageNumberBlock' style='cursor: pointer;' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")' onclick='goToPage(\"".$numbers."\", \"".$id."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div>";

		echo "<a href='".$link."2' class='noBorder'><div class='pageNumberBlockSide' id='pbNext' style='cursor: pointer;' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")' onclick='goToPage(\"2\", \"".$id."\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div></a>";

		echo "</div>";
	}
}