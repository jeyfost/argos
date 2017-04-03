<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 8:34
 */

include("../../connect.php");

$req = false;
ob_start();

$id = $mysqli->real_escape_string($_POST['vacancy']);

if($mysqli->query("UPDATE vacancies SET opened = '0' WHERE id = '".$id."'")) {
	echo "ok";
} else {
	echo "failed";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;