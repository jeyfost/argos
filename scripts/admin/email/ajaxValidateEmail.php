<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 13:32
 */

if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	echo "ok";
}