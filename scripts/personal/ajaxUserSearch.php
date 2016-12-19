<?php

include("../connect.php");

$query = $mysqli->real_escape_string($_POST['query']);

$userResult = $mysqli->query("SELECT * FROM users WHERE login LIKE '%".$query."%' OR email LIKE '%".$query."%' OR name LIKE '%".$query."%' OR company LIKE '%".$query."%' OR position LIKE '%".$query."%' ORDER BY login LIMIT 10");

if($userResult->num_rows == 0) {
	echo "<i>К сожалению, поиск не дал результата.</i>";
} else {
	while($user = $userResult->fetch_assoc()) {
		echo "
			<a class='searchLink' href='personal.php?section=2&user=".$user['id']."'>
				<div class='searchItem' style='border: 1px solid #ddd;'>
				<div style='width: 100%; height: 10px;'></div>
					<table style='position: relative; margin: 0 auto;'>
						<tr class='headTR' style='background-color: #badfff;'>
							<td nowrap>ID</td>
								<td nowrap>Логин</td>
								<td nowrap>Email</td>
								<td nowrap>Имя</td>
								<td nowrap>Организация</td>
								<td nowrap>Должность</td>
								<td nowrap>Скидка</td>
								<td nowrap>Дата регистрации</td>
								<td nowrap>Последний визит</td>
								<td nowrap>Просмотрено страниц</td>
							</tr>
							<tr>
								<td style='text-align: center;'>".$user['id']."</td>
								<td>".$user['login']."</td>
								<td>".$user['email']."</td>
								<td>".$user['name']."</td>
								<td>".$user['company']."</td>
								<td>".$user['position']."</td>
								<td style='text-align: center;'>".$user['discount']."%</td>
								<td>".$user['registration_date']."</td>
								<td>".$user['last_login']."</td>
								<td style='text-align: center;'>".$user['logins_count']."</td>
							</tr>
					</table>
					<div style='clear: both; height: 20px;'></div>
				</div>
			</a>
		";
	}
}