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

function generateSitemapXML() {
    unlink("sitemap.xml");

    global $mysqli;

    $dom = new DomDocument("1.0", "UTF-8");

    $urlset = $dom->appendChild($dom->createElement("urlset"));
    $urlset_attr = $dom->createAttribute("xmlns");
    $urlset_attr->value = "http://www.sitemaps.org/schemas/sitemap/0.9";
    $urlset->appendChild($urlset_attr);

    //---------------------------------------------------------//
    //Каталог
    //---------------------------------------------------------//

    $typeResult = $mysqli->query("SELECT * FROM types ORDER BY id");
    while($type = $typeResult->fetch_assoc()) {
        $url = $urlset->appendChild($dom->createElement("url"));

        $loc = $url->appendChild($dom->createElement("loc"));
        $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/catalogue/index.php?type=".$type['catalogue_type']."&p=1"));

        $lastmod = $url->appendChild($dom->createElement("lastmod"));
        $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("index.php"))));

        $changefreq = $url->appendChild($dom->createElement("changefreq"));
        $changefreq->appendChild($dom->createTextNode("always"));

        $priority = $url->appendChild($dom->createElement("priority"));
        $priority->appendChild($dom->createTextNode("1.0"));

        $quantityResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE type = '".$type['catalogue_type']."'");
        $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

        $numbers = quantity($quantity[0]);

        for($i = 1; $i <= $numbers; $i++) {
            $url = $urlset->appendChild($dom->createElement("url"));

            $loc = $url->appendChild($dom->createElement("loc"));
            $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/catalogue/index.php?type=".$type['catalogue_type']."&p=".$i));

            $lastmod = $url->appendChild($dom->createElement("lastmod"));
            $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("index.php"))));

            $changefreq = $url->appendChild($dom->createElement("changefreq"));
            $changefreq->appendChild($dom->createTextNode("always"));

            $priority = $url->appendChild($dom->createElement("priority"));
            $priority->appendChild($dom->createTextNode("1.0"));
        }

        $categoryResult = $mysqli->query("SELECT * FROM categories_new WHERE type = '".$type['catalogue_type']."'");
        while($category = $categoryResult->fetch_assoc()) {
            $quantityResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE category = '".$category['id']."'");
            $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

            $numbers = quantity($quantity[0]);

            for($i = 1; $i <= $numbers; $i++) {
                $url = $urlset->appendChild($dom->createElement("url"));

                $loc = $url->appendChild($dom->createElement("loc"));
                $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&p=".$i));

                $lastmod = $url->appendChild($dom->createElement("lastmod"));
                $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("index.php"))));

                $changefreq = $url->appendChild($dom->createElement("changefreq"));
                $changefreq->appendChild($dom->createTextNode("always"));

                $priority = $url->appendChild($dom->createElement("priority"));
                $priority->appendChild($dom->createTextNode("1.0"));
            }

            $subcategoryCheckResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$category['id']."'");
            $subcategoryCheck = $subcategoryCheckResult->fetch_array(MYSQLI_NUM);

            if($subcategoryCheck[0] > 0) {
                $subcategoryResult = $mysqli->query("SELECT * FROM subcategories_new WHERE category = '".$category['id']."'");
                while($subcategory = $subcategoryResult->fetch_assoc()) {
                    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory = '".$subcategory['id']."'");
                    $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

                    $numbers = quantity($quantity[0]);

                    for($i = 1; $i <= $numbers; $i++) {
                        $url = $urlset->appendChild($dom->createElement("url"));

                        $loc = $url->appendChild($dom->createElement("loc"));
                        $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&subcategory=".$subcategory['id']."&p=".$i));

                        $lastmod = $url->appendChild($dom->createElement("lastmod"));
                        $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("index.php"))));

                        $changefreq = $url->appendChild($dom->createElement("changefreq"));
                        $changefreq->appendChild($dom->createTextNode("always"));

                        $priority = $url->appendChild($dom->createElement("priority"));
                        $priority->appendChild($dom->createTextNode("1.0"));
                    }

                    $subcategory2CheckResult = $mysqli->query("SELECT COUNT(id) FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
                    $subcategory2Check = $subcategory2CheckResult->fetch_array(MYSQLI_NUM);

                    if($subcategory2Check[0] > 0) {
                        $subcategory2Result = $mysqli->query("SELECT * FROM subcategories2 WHERE subcategory = '".$subcategory['id']."'");
                        while ($subcategory2 = $subcategory2Result->fetch_assoc()) {
                            $quantityResult = $mysqli->query("SELECT COUNT(id) FROM catalogue_new WHERE subcategory2 = '".$subcategory2['id']."'");
                            $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

                            $numbers = quantity($quantity[0]);

                            for($i = 1; $i <= $numbers; $i++) {
                                $url = $urlset->appendChild($dom->createElement("url"));

                                $loc = $url->appendChild($dom->createElement("loc"));
                                $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/catalogue/index.php?type=".$type['catalogue_type']."&c=".$category['id']."&subcategory=".$subcategory['id']."&subcategory2=".$subcategory2['id']."&p=".$i));

                                $lastmod = $url->appendChild($dom->createElement("lastmod"));
                                $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("index.php"))));

                                $changefreq = $url->appendChild($dom->createElement("changefreq"));
                                $changefreq->appendChild($dom->createTextNode("always"));

                                $priority = $url->appendChild($dom->createElement("priority"));
                                $priority->appendChild($dom->createTextNode("1.0"));
                            }
                        }
                    }
                }
            }
        }
    }

    //---------------------------------------------------------//

    $goodResult = $mysqli->query("SELECT * FROM catalogue_new");
    while($good = $goodResult->fetch_assoc()) {
        $url = $urlset->appendChild($dom->createElement("url"));

        $loc = $url->appendChild($dom->createElement("loc"));
        $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/catalogue/item.php?id=".$good['id']));

        $lastmod = $url->appendChild($dom->createElement("lastmod"));
        $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("catalogue/item.php"))));

        $changefreq = $url->appendChild($dom->createElement("changefreq"));
        $changefreq->appendChild($dom->createTextNode("always"));

        $priority = $url->appendChild($dom->createElement("priority"));
        $priority->appendChild($dom->createTextNode("1.0"));
    }

    //---------------------------------------------------------//
    //О компании
    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/about/info.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("about/info.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/about/assortment.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("about/assortment.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/about/awards.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("about/awards.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/about/gallery.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("about/gallery.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/about/vacancies.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("about/vacancies.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//
    //Новости
    //---------------------------------------------------------//

    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM news");
    $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

    $numbers = quantity($quantity[0]);

    for($i = 1; $i <= $numbers; $i++) {
        $url = $urlset->appendChild($dom->createElement("url"));

        $loc = $url->appendChild($dom->createElement("loc"));
        $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/news.php?p=".$i));

        $lastmod = $url->appendChild($dom->createElement("lastmod"));
        $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("news.php"))));

        $changefreq = $url->appendChild($dom->createElement("changefreq"));
        $changefreq->appendChild($dom->createTextNode("always"));

        $priority = $url->appendChild($dom->createElement("priority"));
        $priority->appendChild($dom->createTextNode("1.0"));
    }

    $yearResult = $mysqli->query("SELECT DISTINCT year FROM news");
    while($year = $yearResult->fetch_assoc()) {
        $quantityResult = $mysqli->query("SELECT COUNT(id) FROM news WHERE year = '".$year['year']."'");
        $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

        $numbers = quantity($quantity[0]);

        for($i = 1; $i <= $numbers; $i++) {
            $url = $urlset->appendChild($dom->createElement("url"));

            $loc = $url->appendChild($dom->createElement("loc"));
            $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/news.php?year=".$year['year']."&p=".$i));

            $lastmod = $url->appendChild($dom->createElement("lastmod"));
            $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("news.php"))));

            $changefreq = $url->appendChild($dom->createElement("changefreq"));
            $changefreq->appendChild($dom->createTextNode("always"));

            $priority = $url->appendChild($dom->createElement("priority"));
            $priority->appendChild($dom->createTextNode("1.0"));
        }
    }

    $newsResult = $mysqli->query("SELECT * FROM news");
    while($news = $newsResult->fetch_assoc()) {
        $url = $urlset->appendChild($dom->createElement("url"));

        $loc = $url->appendChild($dom->createElement("loc"));
        $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/news.php?id=".$news['id']));

        $lastmod = $url->appendChild($dom->createElement("lastmod"));
        $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("news.php"))));

        $changefreq = $url->appendChild($dom->createElement("changefreq"));
        $changefreq->appendChild($dom->createTextNode("monthly"));

        $priority = $url->appendChild($dom->createElement("priority"));
        $priority->appendChild($dom->createTextNode("1.0"));
    }

    //---------------------------------------------------------//
    //Где купить
    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/stores/company.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("stores/company.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/stores/representatives.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("stores/representatives.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//
    //Акции
    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/actions.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("actions.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("always"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $actionResult = $mysqli->query("SELECT * FROM actions");
    while($action = $actionResult->fetch_assoc()) {
        $url = $urlset->appendChild($dom->createElement("url"));

        $loc = $url->appendChild($dom->createElement("loc"));
        $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/actions.php?id=".$action['id']));

        $lastmod = $url->appendChild($dom->createElement("lastmod"));
        $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("actions.php"))));

        $changefreq = $url->appendChild($dom->createElement("changefreq"));
        $changefreq->appendChild($dom->createTextNode("monthly"));

        $priority = $url->appendChild($dom->createElement("priority"));
        $priority->appendChild($dom->createTextNode("1.0"));
    }

    //---------------------------------------------------------//
    //Партнёрам
    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/partners/cooperation.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("partners/cooperation.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/partners/news.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("partners/news.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//
    //Партнёрам
    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/contacts/stores.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("contacts/stores.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/contacts/main.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("contacts/main.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//

    $url = $urlset->appendChild($dom->createElement("url"));

    $loc = $url->appendChild($dom->createElement("loc"));
    $loc->appendChild($dom->createTextNode("https://".$_SERVER['HTTP_HOST']."/contacts/mail.php"));

    $lastmod = $url->appendChild($dom->createElement("lastmod"));
    $lastmod->appendChild($dom->createTextNode(date("Y-m-d H:i:s", filemtime("contacts/mail.php"))));

    $changefreq = $url->appendChild($dom->createElement("changefreq"));
    $changefreq->appendChild($dom->createTextNode("monthly"));

    $priority = $url->appendChild($dom->createElement("priority"));
    $priority->appendChild($dom->createTextNode("1.0"));

    //---------------------------------------------------------//
    //Генерация XML
    //---------------------------------------------------------//

    $dom->formatOutput = true;
    $sitemap = $dom->saveXML();
    $dom->save("sitemap.xml");
}

function quantity($quantity) {
    if($quantity > 10) {
        if($quantity % 10 != 0) {
            $numbers = intval(($quantity / 10) + 1);
        } else {
            $numbers = intval($quantity / 10);
        }
    } else {
        $numbers = 1;
    }

    return $numbers;
}