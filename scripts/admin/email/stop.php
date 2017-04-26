<!doctype html>

<html>

<head>
	<meta charset="utf-8">

	<title>Отписка от рассылки</title>

	<link rel='icon' href='/img/icons/favicon.ico' type='image/x-icon'>
	<link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<style>
		#page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
		#page-preloader .spinner {width: 32px; height: 32px; position: absolute; left: 50%; top: 50%; background: url('/img/system/spinner.gif') no-repeat 50% 50%; margin: -16px 0 0 -16px;}
	</style>

    <script type="text/javascript">
        $(window).on('load', function () {
            var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
            $spinner.delay(500).fadeOut();
            $preloader.delay(850).fadeOut('slow');
        });
    </script>
</head>

<body>

	<div id="page-preloader"><span class="spinner"></span></div>

<?php

echo "
	<div style='margin: 20px auto 0 auto; width: 90%; text-align: center;'>
		<img src='/img/system/logo_400.png' />
		<br />
		<div style='margin: 70px auto 0 auto; width: 600px;'>
";

include('../../connect.php');

if(!empty($_REQUEST['hash'])) {
	$userCheckResult = $mysqli->query("SELECT COUNT(id) FROM clients WHERE hash = '".$mysqli->real_escape_string($_REQUEST['hash'])."'");
	$userCheck = $userCheckResult->fetch_array(MYSQLI_NUM);

	if($userCheck[0] > 0) {
		$userResult = $mysqli->query("SELECT * FROM clients WHERE hash = '".$mysqli->real_escape_string($_REQUEST['hash'])."'");
		$user = $userResult->fetch_assoc();

		if($user['in_send'] == 1) {
			if($mysqli->query("UPDATE clients SET in_send = 0 WHERE id = '".$user['id']."'")) {
				echo "Вы были успешно отписаны от рассылки. Больше мы вам ничего не пришлём.";
			} else {
				echo "Во время отписки произошла ошибка. Попробуйте повторить попытку либо свяжитесь с нами для разрешения ситуации. Контактную информацию можно найти <a href='/contacts/main.php' target='_blank'><span class='redLink'>здесь</span></a>. Или воспользуйтесь <a href='/contacts/mail.php' target='_blank'><span class='redLink'>формой обратной связи</span></a>.";
			}
		} else {
			echo "Вы уже были отписаны от рассылки ранее.";
		}
	} else {
		echo "Вы попали на страницу отписки от рассылки, однако ваш секретный код является неверным. Свяжитесь с нами для разрешения ситуации. Контактную информацию можно найти <a href='/contacts/main.php' target='_blank'><span class='redLink'>здесь</span></a>. Или воспользуйтесь <a href='/contacts/mail.php' target='_blank'><span class='redLink'>формой обратной связи</span></a>.";
	}
} else {
	echo "Вы попали на страницу отписки от рассылки, но вы не указали ваш секретный код. Свяжитесь с нами для разрешения ситуации. Контактную информацию можно найти <a href='/contacts/main.php' target='_blank'><span class='redLink'>здесь</span></a>. Или воспользуйтесь <a href='/contacts/mail.php' target='_blank'><span class='redLink'>формой обратной связи</span></a>.";
}

?>
		</div>
	</div>

</body>

</html>
