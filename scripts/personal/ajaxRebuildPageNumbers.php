<?php

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['userID']);
$page = $mysqli->real_escape_string($_POST['page']);

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
		if($page == 1) {
			echo "<br /><br /><div class='pageNumberBlockSide' ><span class='goodStyle'>Предыдущая</span></div>";
		} else {
			echo "<br /><br /><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")' onclick='goToPage(\"".($page - 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div>";
		}

		for($i = 1; $i <= $numbers; $i++) {
			echo "<div id='pb".$i."' "; if($i == $page) {echo "class='pageNumberBlockActive' style='cursor: default;'";} else {echo "class='pageNumberBlock' style='cursor: pointer;' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")' onclick='goToPage(\"".$i."\", \"".$id."\")'";} echo "><span "; if($i == $page) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";
		}

		if($page < $numbers) {
			echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: pointer;' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")' onclick='goToPage(\"2\", \"".$id."\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div>";
		} else {
			echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"../img/cursor/no.cur\"), auto;'<span class='goodStyle'>Следующая</span></div>";
		}
	} else {
		if($page < 5) {
			if($page == 1) {
				echo "<br /><br /><div class='pageNumberBlockSide'><span class='goodStyle'>Предыдущая</span></div>";
			} else {
				echo "<br /><br /><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")' onclick='goToPage(\"".($page - 1)."\", \"".$id."\")'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div>";
			}

			for($i = 1; $i <= 5; $i++) {
				echo "<div id='pb".$i."' "; if($i == $page) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")' onclick='goToPage(\"".$i."\", \"".$id."\")'";} echo "><span "; if($i == $page) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";
			}

			echo "<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>";
			echo "<div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onclick='goToPage(\"".$numbers."\", \"".$id."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div>";

			if($page == $numbers) {
				echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
			} else {
				echo "<div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")' onclick='goToPage(\"".$numbers."\", \"".$id."\")'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div>";
			}

			echo "</div>";
		} else {
			$check = $numbers - 3;

			if($page >= 5 and $page < $check) {
				echo "
					<br /><br />
					<div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")' onclick='goToPage(\"".($page - 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div>
					<div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")' onclick='goToPage(\"1\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbt1'>1</span></div>
					<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
					<div id='pb".($page - 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($page - 1)."\", \"pbt".($page - 1)."\")' onmouseout='pageBlock(0, \"pb".($page - 1)."\", \"pbt".($page - 1)."\")' onclick='goToPage(\"".($page - 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbt".($page - 1)."'>".($page - 1)."</span></div>
					<div class='pageNumberBlockActive'><span class='goodStyleWhite'>".$page."</span></div>
					<div id='pb".($page + 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($page + 1)."\", \"pbt".($page + 1)."\")' onmouseout='pageBlock(0, \"pb".($page + 1)."\", \"pbt".($page + 1)."\")' onclick='goToPage(\"".($page + 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbt".($page + 1)."'>".($page + 1)."</span></div>
					<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
					<div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")' onclick='goToPage(\"".$numbers."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbt".$numbers."'>".$numbers."</span></div>
					<div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")' onclick='goToPage(\"".($page + 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div>
				";
			} else {
				echo "
					<br /><br />
					<div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")' onclick='goToPage(\"".($page - 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbtPrev'>Предыдущая</span></div>
					<div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")' onclick='goToPage(\"1\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbt1'>1</span></div>
					<div class='pageNumberBlock' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>...</span></div>
				";

				for($i = ($numbers - 4); $i <= $numbers; $i++) {
					echo "<div id='pb".$i."' "; if($i == $page) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")' onclick='goToPage(\"".$i."\", \"".$id."\")' style='cursor: pointer;'";} echo "><span "; if($i == $page) {echo "class='goodStyleWhite'";} else {echo "class='goodStyleRed' id='pbt".$i."'";} echo ">".$i."</span></div>";
				}

				if($page == $numbers) {
					echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(\"img/cursor/no.cur\"), auto;'><span class='goodStyle'>Следующая</span></div>";
				} else {
					echo "<div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")' onclick='goToPage(\"".($page + 1)."\", \"".$id."\")' style='cursor: pointer;'><span class='goodStyleRed' id='pbtNext'>Следующая</span></div>";
				}
			}
		}
	}
}