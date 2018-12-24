<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.07.2017
 * Time: 16:12
 */

session_start();
include("../connect.php");
include("../helpers.php");

$id = $mysqli->real_escape_string($_POST['order_id']);

$commentResult = $mysqli->query("SELECT * FROM orders_comments WHERE order_id = '".$id."' AND user_id = '".$_SESSION['userID']."' ORDER BY id DESC LIMIT 1");
$comment = $commentResult->fetch_assoc();

$authorResult = $mysqli->query("SELECT name FROM users WHERE id = '".$comment['user_id']."'");
$author = $authorResult->fetch_array(MYSQLI_NUM);

$commentsCountResult = $mysqli->query("SELECT COUNT(id) FROM orders_comments WHERE order_id = '".$id."'");
$commentsCount = $commentsCountResult->fetch_array(MYSQLI_NUM);

$number = $commentsCount[0];

echo "
	<div class='orderComment'>
		<div style='border-bottom: 1px dotted #999; padding: 5px;'><b>Комментарий №".$number."</b> от <b>".dateFormatted($comment['date'])."</b>. Автор: <b>"; if($comment['user_id'] == 1) {echo "<span style='color: #ff282b;'>".$author[0]."</span>";} else {echo $author[0];} echo "</b></div>
		<div class='commentSection'><br />".$comment['text']."</div>
	</div>
";