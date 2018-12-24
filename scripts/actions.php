<?php

function echoAction($actions) {
	$month = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
	$index1 = (int)substr($actions['from_date'], 3, 2) - 1;
	$from_date = substr($actions['from_date'], 0, 2)." ".$month[$index1]." ".substr($actions['from_date'], 6, 4);
	$index2 = (int)substr($actions['to_date'], 3, 2) - 1;
	$to_date = substr($actions['to_date'], 0, 2)." ".$month[$index2]." ".substr($actions['to_date'], 6, 4);

	echo "
		<a href='actions.php?id=".$actions['id']."'>
			<div class='newsPreview' id='newsPreview".$actions['id']."'>
				<img src='/img/photos/actions/".$actions['preview']."' />
				<br /><br />
				<div style='text-align: left;'>
					<span style='color: #ff282b; font-style: italic; font-size: 14px;'>"; if($actions['from_date'] != $actions['to_date']) { echo $from_date." — ".$to_date;} else {echo $from_date;} echo "</span>
					<p style='color: #4c4c4c; margin-top: 0;'>".$actions['header']."</p>
					<br />
					<div style='text-align: right;'><img src='/img/system/arrow.png' /></div>
				</div>
			</div>
		</a>
	";
}