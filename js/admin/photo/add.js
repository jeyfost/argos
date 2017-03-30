/**
 * Created by jeyfost on 29.03.2017.
 */

function addPhotos() {
	var formData = new FormData($('#addForm').get(0));
	var photo = $('#photoInput').val();

	if(photo !== '') {
		$.ajax({
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			url: "../../scripts/admin/photo/ajaxAddPhotos.php",
			beforeSend: function() {
				$.notify("Фотографии добавляются...", "info");
			},
			success: function(response) {
				switch(response) {
					case "ok":
						$.notify("Добавление прошло успешно.", "success");
						break;
					case "failed":
						$.notify("Во время добавления произошла ошибка.", "error");
						break;
					case "partly":
						$.notify("Не все фотографии были успешно добавлены.", "warn");
						break;
					case "error":
						$.notify("Некоторые файлы имеют недопустимый формат.", "error");
						break;
					default:
						$.notify(response, "warn");
						break;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	} else {
		$.notify("Выберите фотографии.", "error");
	}
}