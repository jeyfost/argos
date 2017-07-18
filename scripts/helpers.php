<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.07.2017
 * Time: 15:54
 */

function getMonth($month) {
	switch ($month) {
		case 1:
			$name = "января";
			break;
		case 2:
			$name = "февраля";
			break;
		case 3:
			$name = "марта";
			break;
		case 4:
			$name = "апреля";
			break;
		case 5:
			$name = "мая";
			break;
		case 6:
			$name = "июня";
			break;
		case 7:
			$name = "июля";
			break;
		case 8:
			$name = "августа";
			break;
		case 9:
			$name = "сентября";
			break;
		case 10:
			$name = "октября";
			break;
		case 11:
			$name = "ноября";
			break;
		case 12:
			$name = "декабря";
			break;
		default:
			$name = null;
			break;
	}

	return $name;
}

function dateFormatted($date) {
	$date = (int)substr($date, 8, 2)." ".getMonth((int)substr($date, 5, 2))." ".substr($date, 0, 4)." г. в ".substr($date, 11);
	return $date;
}

function dateFormattedDayToYear($date) {
	$date = (int)substr($date, 0, 2)." ".getMonth((int)substr($date, 3, 2))." ".substr($date, 6, 4)." г. в ".substr($date, 11);
	return $date;
}

function file_get_contents_curl($url)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	$data = curl_exec($ch);

	curl_close($ch);

	return $data;
}