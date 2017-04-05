<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.04.2017
 * Time: 14:52
 */

include("../../connect.php");

echo "
	<label for='subjectInput'>Тема сообщения:</label>
	<br />
	<input type='text' id='subjectInput' name='subject' />
	<br /><br />
	<label for='districtSelect'>Выберите область:</label>
	<br />
	<select id='districtSelect' name='district' onchange='loadDistrictButtons()'>
		<option value=''>- Выберите область -</option>
";

$districtResult = $mysqli->query("SELECT * FROM locations ORDER BY id");
while($district = $districtResult->fetch_assoc()) {
	echo "<option value='".$district['id']."'>".$district['name']."</option>";
}

echo "
	</select>
	<div id='districtButtons'></div>
	<br /><br />
	<label for='textInput'>Текст письма:</label>
	<br />
	<textarea id='textInput' name='text'></textarea>
	<br /><br />
	<label for='fileInput'>Добавить вложения:</label>
	<br />
	<input type='file' class='file' name='attachment[]' multiple='multiple' />
";