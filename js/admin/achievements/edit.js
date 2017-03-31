/**
 * Created by jeyfost on 31.03.2017.
 */

function editAward() {
	var formData = new FormData($('#editForm').get(0));
	var name = $('#nameInput').val();

	if(name !== '') {
		$.ajax({
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			url: "../../scripts/admin/achievements/ajaxEditAward.php",
			success: function(response) {
				switch(response) {
					case "ok":
						$.notify("Редактирование прошло успешно.", "success");
						break;
					case "failed":
						$.notify("Во время редактирования произошла ошибка.", "error");
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
		$.notify("Введите название награды.", "error");
	}
}