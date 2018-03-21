/**
 * Created by jeyfost on 03.04.2017.
 */

function editVacancy() {
	var formData = new FormData($('#editForm').get(0));
	var name = $('#positionInput').val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;

	formData.append("text", text);

	if(name !== '') {
		$.ajax({
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			url: "/scripts/admin/vacancies/ajaxEditVacancy.php",
			success: function(response) {
				switch(response) {
					case "ok":
						$.notify("Редактирование прошло успешно.", "success");
						break;
					case "failed":
						$.notify("Во время редактирования произошла ошибка.", "error");
						break;
					case "duplicate":
						$.notify("Вакансия на такую должность уже открыта.", "error");
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
