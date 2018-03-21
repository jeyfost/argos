/**
 * Created by jeyfost on 31.03.2017.
 */

function addAward() {
	var formData = new FormData($('#addForm').get(0));
	var photo = $('#photoInput').val();
	var name = $('#nameInput').val();

	if(name !== '') {
		if(photo !== '') {
			$.ajax({
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				dataType: "json",
				url: "/scripts/admin/achievements/ajaxAddPhotos.php",
				beforeSend: function() {
					$.notify("Награда добавляется...", "info");
				},
				success: function(response) {
					switch(response) {
						case "ok":
							$.notify("Добавление прошло успешно.", "success");
							break;
						case "failed":
							$.notify("Во время добавления произошла ошибка.", "error");
							break;
						case "error":
							$.notify("Фотография имеет недопустимый формат.", "error");
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
			$.notify("Выберите фотографию.", "error");
		}
	} else {
		$.notify("Введите название награды.", "error");
	}
}