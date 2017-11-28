<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 27.11.2017
 * Time: 16:28
 */

include("../../connect.php");

echo "
	<label for='subjectInput'>Тема сообщения:</label>
	<br />
	<input type='text' id='subjectInput' name='subject' />
	<br /><br />
	<label for='districtSelect'>Выберите область:</label>
	<br />
	<select id='districtSelect' name='district' onchange='loadDistrictButtonsFilter()'>
		<option value=''>- Выберите область -</option>
";

$districtResult = $mysqli->query("SELECT * FROM locations ORDER BY id");
while($district = $districtResult->fetch_assoc()) {
	echo "<option value='".$district['id']."'>".$district['name']."</option>";
}

echo "
	</select>
	<br /><br />
	<label for='groupSelect'>Выберите группу:</label>
	<br />
	<select id='groupSelect' name='group' onchange='loadDistrictButtonsFilter()'>
		<option value=''>- Выберите группу -</option>
";

$groupResult = $mysqli->query("SELECT * FROM filters ORDER BY name");
while($group = $groupResult->fetch_assoc()) {
	echo "<option value='".$group['id']."'>".$group['name']."</option>";
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