<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 12:35
 */

include("../../connect.php");

$req = false;
ob_start();

echo $_POST['recipient'];

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;