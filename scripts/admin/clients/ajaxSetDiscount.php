<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 01.02.2023
 * Time: 10:30
 */

include("../../connect.php");

$req = false;
ob_start();

$card = $mysqli->real_escape_string($_POST['card']);
$discount = $mysqli->real_escape_string($_POST['discount']);

$userCountResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE card = '".$card."'");
$userCount = $userCountResult->fetch_array(MYSQLI_NUM);

if($userCount[0] > 0) {
    if($mysqli->query("UPDATE users SET discount = '".$discount."' WHERE card = '".$card."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "card";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;