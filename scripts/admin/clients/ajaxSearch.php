<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.04.2017
 * Time: 15:40
 */

include("../../connect.php");

$query = $mysqli->real_escape_string($_POST['search']);

$searchResult = $mysqli->query("SELECT * FROM clients WHERE name LIKE '%".$query."%' OR email LIKE '%".$query."%' OR phone LIKE '%".$query."%' LIMIT 10");

$i = 0;

if($searchResult->num_rows > 0) {
	while($search = $searchResult->fetch_assoc()) {
		$i++;

		$locationResult = $mysqli->query("SELECT name FROM locations WHERE id = '".$search['location']."'");
		$location = $locationResult->fetch_array(MYSQLI_NUM);

		echo "
			<a href='edit.php?id=".$search['id']."' class='basicText'>
				<div class='searchItem' id='si".$search['id']."' style='padding: 5px;"; if($i % 2 == 0) {echo " background-color: #d9d9d9";} echo "' onmouseover='searchItemHover(\"si".$search['id']."\", 1, \"".$i."\")' onmouseout='searchItemHover(\"si".$search['id']."\", 0, \"".$i."\")' title='Редактировать'>
					<b>Имя/название:</b> ".$search['name']."
					<br />
					<b>Телефон:</b> ".$search['phone']."
					<br />
					<b>Email:</b> ".$search['email']."
					<br />
					<b>Область:</b> ".$location[0]."
					<br />
					<b>В рассылке:</b> "; if($search['in_send'] == 1) {echo "да";} else {echo "нет";}

					if($search['in_send'] == 0) {
						$date = (int)substr($search['disactivation_date'], 8, 2)." ";

						switch(substr($search['disactivation_date'], 5, 2)) {
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

						$date .= " ".substr($search['disactivation_date'], 0, 4)." г. в ".substr($search['disactivation_date'], 11);

						echo "
							<br />
							<b>Дата отписки:</b> ".$date."
						";
					}

					echo "
				</div>
			</a>
		";
	}
} else {
	echo "К сожалению, по вашему запросу ничего не найдено.";
}