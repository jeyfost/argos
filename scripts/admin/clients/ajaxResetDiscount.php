<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 01.02.2023
 * Time: 10:18
 */

include("../../connect.php");

$req = false;
ob_start();

if($mysqli->query("UPDATE users SET discount = '0' WHERE card <> '0001' AND card <> '0002' AND card <> '9999'")) {
    echo "ok";
} else {
    echo "failed";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;