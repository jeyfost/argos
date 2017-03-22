<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 22.03.2017
 * Time: 12:08
 */

include("../../connect.php");

$req = false;
ob_start();

$newsResult = $mysqli->query("SELECT * FROM news WHERE id = '".$_POST['news']."'");
$news = $newsResult->fetch_assoc();

if($mysqli->query("DELETE FROM news WHERE id = '".$news['id']."'")) {
	unlink("../../../img/photos/news/".$news['preview']);

	echo "ok";
} else {
	echo "failed";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;