<?php

session_start();
include("../connect.php");

$query = $mysqli->real_escape_string($_POST['query']);

/*
 * $searchResult = $mysqli->query("SELECT * FROM catalogue_new WHERE name LIKE '%".$query."%' OR code LIKE '%".$query."%' OR description LIKE '%".$query."%' ORDER BY quantity > 0 DESC, name LIMIT 10");

 *  $searchFullResult = $mysqli->query("SELECT * FROM catalogue_new WHERE name LIKE '%".$query."%' OR code LIKE '%".$query."%' OR description LIKE '%".$query."%'");
 */

/*
$searchResult = $mysqli->query("SELECT catalogue_new.*, MATCH (`name`, `description`, `code`) AGAINST ('*.$query.*' IN BOOLEAN MODE) AS relevance, MATCH (`name`) AGAINST ('*.$query.*' IN BOOLEAN MODE) AS name_relevance, MATCH (`code`) AGAINST ('*.$query.*' IN BOOLEAN MODE) AS code_relevance, `quantity` AS quantity_relevance  FROM catalogue_new WHERE MATCH (`name`, `description`, `code`) AGAINST ('*".$query."*' IN BOOLEAN MODE) ORDER BY quantity_relevance DESC, name_relevance DESC, code_relevance DESC, relevance DESC LIMIT 10");

$searchFullResult = $mysqli->query("SELECT catalogue_new.*, MATCH (`name`, `description`, `code`) AGAINST ('*.$query.*' IN BOOLEAN MODE) AS relevance, MATCH (`name`) AGAINST ('*.$query.*' IN BOOLEAN MODE) AS name_relevance, MATCH (`code`) AGAINST ('*.$query.*' IN BOOLEAN MODE) AS code_relevance, `quantity` AS quantity_relevance  FROM catalogue_new WHERE MATCH (`name`, `description`, `code`) AGAINST ('*".$query."*' IN BOOLEAN MODE) ORDER BY quantity_relevance DESC, name_relevance DESC, code_relevance DESC, relevance DESC");
*/

if(isset($_SESSION['userID'])) {
    $userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
    $user = $userResult->fetch_assoc();
}

$keywords = explode(" ", $query);
$searchConditions = array();

foreach ($keywords as $keyword) {
    $keyword = trim($keyword);
    if(!empty($keyword)) {
        $condition = "(name LIKE '%$keyword%' OR description LIKE '%$keyword%' OR code = '$keyword')";
    }

    $searchConditions[] = $condition;
}

$searchFullResult = $mysqli->query("SELECT * FROM catalogue_new WHERE " . implode(' AND ', $searchConditions));
$searchFull = $searchFullResult->num_rows;

$sql = "SELECT *, (CASE WHEN quantity > 0 THEN 0 ELSE 1 END) AS out_of_stock 
        FROM catalogue_new 
        WHERE " . implode(' AND ', $searchConditions) . " 
        ORDER BY out_of_stock, name 
        LIMIT 10";
$searchResult = $mysqli->query($sql);


if($searchResult->num_rows == 0) {
    echo "<i>К сожалению, поиск не дал результата.</i>";
} else {
    echo "
        <br />
        <div style='margin: 0 auto; text-align: center;'><a href='/search/?query=".$query."'><span class='sketchFont'>Посмотреть все результаты (".$searchFull.")</span></a></div>
        <br />
    ";

    $j = 0;

    while($search = $searchResult->fetch_assoc()) {
        $j++;
        $unitResult = $mysqli->query("SELECT * FROM units WHERE id = '".$search['unit']."'");
        $unit = $unitResult->fetch_assoc();

        $active = 0;

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
                    $aID = $action['id'];
                }
            }
        }

        if(($user['opt'] == 1 and ($search['price'] == 0 or $search['price'] == null or $search['price_opt'] == 0)) or ($user['opt'] == 0 and ($search['price'] == 0 or $search['price'] == null))) {
            $price = " по запросу";
        } else {
            $rateResult = $mysqli->query("SELECT rate FROM currency WHERE id = '".$search['currency']."'");
            $rate = $rateResult->fetch_array(MYSQLI_NUM);

            if($active == 0) {
                $price = $search['price'] * $rate[0];
                $price_opt = $search['price_opt'] * $rate[0];

                if(isset($_SESSION['userID'])) {
                    $discountResult = $mysqli->query("SELECT discount FROM users WHERE id = '".$_SESSION['userID']."'");
                    $discount = $discountResult->fetch_array(MYSQLI_NUM);

                    if($user['opt'] == 1) {
                        $price = $price_opt;
                    }

                    $price = $price / ($discount[0] / 100 + 1);
                }
            } else {
                $actionGoodResult = $mysqli->query("SELECT * FROM action_goods WHERE good_id = '".$search['id']."' AND action_id = '".$aID."'");
                $actionGood = $actionGoodResult->fetch_assoc();

                $price = $actionGood['price'] * $rate[0];
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
		    ";

        if($active > 0) {
            echo "<img src='/img/system/action.png' class='actionIMGSearch' />";
        }

        echo "
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
                    <b>Наличие: </b>"; if($search['quantity'] > 0) {echo "на складе";} else {echo "<span style='color: #870000;'>нет на складе</span>";} echo "
					<br />
		";

        if($active == 0) {
            if($_SESSION['userID'] != 1) {
                echo "
			        <b>Цена за ".$unit['short_name']; if($discount[0] > 0) {echo " с учётом скидки";} echo ": </b>".$price."
                ";
            } else {
                $price = $search['price'] * $rate[0];
                $price_opt = $search['price_opt'] * $rate[0];

                if($price > 0) {
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
                } else {
                    $price = "по запросу";
                }

                if($price_opt > 0) {
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
                } else {
                    $price_opt = "не установлена в базе данных";
                }

                echo "
                <b>Цена розничная за ".$unit['short_name'].": </b>".$price."
                <br />
                <b>Цена оптовая за ".$unit['short_name'].": </b>".$price_opt."
            ";
            }
        } else {
            $price = $actionGood['price'] * $rate[0];

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

            echo "
			        <b>Цена за ".$unit['short_name']; if($discount[0] > 0) {echo " с учётом скидки";} echo ": </b><span style='color: #ff282b; font-weight: bold;'>".$price."</span>
                ";
        }

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

    if($searchFull > 10) {
        echo "
            <br />
            <div style='margin: 0 auto; text-align: center;'><a href='/search/?query=".$query."'><span class='sketchFont'>Посмотреть все результаты (".$searchFull.")</span></a></div>
        ";
    }
}