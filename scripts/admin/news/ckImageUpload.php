<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 20.03.2017
 * Time: 12:36
 */

function getex($filename) {
	return end(explode(".", $filename));
}

if($_FILES['upload']) {
	if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
		$message = "Вы не выбрали файл.";
	} else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 2050000) {
		$message = "Размер файла не соответствует нормам.";
	} else if (($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png")) {
		$message = "Допускается загрузка только картинок JPG и PNG.";
	} else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
		$message = "Что-то пошло не так. Попытайтесь загрузить файл ещё раз.";
	} else {
		$name = md5(rand(1, 1000000).'-'.md5($_FILES['upload']['name'])).'.'.getex($_FILES['upload']['name']);

		move_uploaded_file($_FILES['upload']['tmp_name'], "../../../img/photos/content/".$name);

		$full_path = 'https://localhost/test/editor/images/'.$name;
		$message = "Файл ".$_FILES['upload']['name']." загружен.";
		$size = @getimagesize("../../../img/photos/content/".$name);

		if($size[0]<50 OR $size[1]<50) {
			unlink("../../../img/photos/content/".$name);
			$message = "Файл не является допустимым изображением.";
			$full_path = $_SERVER['DOCUMENT_ROOT']."/img/photos/content/".$name;
		}
	}

	$callback = $_REQUEST['CKEditorFuncNum'];

	echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
}
