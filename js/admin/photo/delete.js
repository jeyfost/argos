/**
 * Created by jeyfost on 30.03.2017.
 */

function deletePhoto(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../../scripts/admin/photo/ajaxDeletePhoto.php",
		success: function(response) {
			switch(response) {
				case "ok":
					$.notify("Фотография была успешно удалена.", "success");
					break;
				case "failed":
					$.notify("Во время удаления фотографии произошла ошибка.", "error");
					break;
				case "photo":
					$.notify("Выбранной фотографии не существует. Возможно, она уже была удалена ранее.", "warn");
					break;
				default:
					$.notify(response, "warn");
					break;
				}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.notify(textStatus + "; " + errorThrown, "error");
		}
	})
}