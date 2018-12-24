<?php

session_start();

if($_SESSION['userID'] == 1) {
	header("Location: admin.php");
}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Вход в панель администрирования</title>

    <link rel='shortcut icon' href='/img/icons/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' media='screen' type='text/css' href='/css/admin.css'>
	<link rel="stylesheet" type="text/css" href="/js/lightview/css/lightview/lightview.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<!--[if lt IE 9]>
  		<script type="text/javascript" src="/js/lightview/js/excanvas/excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/js/lightview/js/spinners/spinners.min.js"></script>
	<script type="text/javascript" src="/js/lightview/js/lightview/lightview.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/admin/index.js"></script>

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

<body style="background-color: #e4e4e4;">

	<div id="page-preloader"><span class="spinner"></span></div>

	<div id="loginBlock">
		<form method="post" action="/scripts/admin/login.php">
			<div style="width: 100%; text-align: center;">
				<span>Вход в панель администрирования</span>
				<br /><br />
				<?php
					if(isset($_SESSION['loginError'])) {
						echo "<span style='color: #ff282b; font-size: 14px;'>Введённые вами логин или пароль не верны.</span><br /><br />";
						unset($_SESSION['loginError']);
					}
				?>
			</div>
			<label for="loginInput">Логин:</label>
			<br />
			<input type="text" id="loginInput" name="login" autofocus="autofocus" />
			<br /><br />
			<label for="passwordInput">Пароль:</label>
			<br />
			<input type="password" id="passwordInput" name="password" />
			<br /><br />
			<div style="width: 100%; text-align: center;">
				<input type="submit" value="Войти" id="loginSubmit" onmouseover="buttonChange('loginSubmit', 1)" onmouseout="buttonChange('loginSubmit', 0)" />
			</div>
		</form>
	</div>

</body>

</html>