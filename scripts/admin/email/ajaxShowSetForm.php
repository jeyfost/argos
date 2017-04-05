<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.04.2017
 * Time: 8:53
 */

include("../../connect.php");

echo "
	<label for='subjectInput'>Тема сообщения:</label>
	<br />
	<input type='text' id='subjectInput' name='subject' />
	<br /><br />
	<label for='districtSelect'>Выберите область:</label>
	<br />
	<select id='districtSelect' name='district' onchange='loadClientsGrid()'>
		<option value=''>- Выберите область -</option>
";

$districtResult = $mysqli->query("SELECT * FROM locations ORDER BY id");
while($district = $districtResult->fetch_assoc()) {
	echo "<option value='".$district['id']."'>".$district['name']."</option>";
}

echo "
	</select>
	<div id='clientsGrid'></div>
	<br /><br />
	<label for='textInput'>Текст письма:</label>
	<br />
	<textarea id='textInput' name='text'></textarea>
	<br /><br />
	<label for='fileInput'>Добавить вложения:</label>
	<br />
	<input type='file' class='file' name='attachment[]' multiple='multiple' />
	<br /><br />
	<input type='button' class='button' style='margin: 0;' id='sendEmailButton' onmouseover='buttonChange(\"sendEmailButton\", 1)' onmouseout='buttonChange(\"sendEmailButton\", 0)' onclick='sendEmail()' value='Отправить' />
";