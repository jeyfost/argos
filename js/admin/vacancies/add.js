/**
 * Created by jeyfost on 01.04.2017.
 */

function addVacancy() {
	var position = $("#positionInput").val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;

	if(position !== '') {
		if(text !== '' && text !== "<p><br></p>") {
			$.ajax({
				type: "POST",
				data: {"position": position, "text": text},
				url: "../../scripts/admin/vacancies/ajaxAddVacancy.php",
				success: function (response) {
					switch(response) {
						case "ok":
							$.notify("Добавление прошло успешно.", "success");
							break;
						case "failed":
							$.notify("Во время добавления произошла ошибка.", "error");
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
			$.notify("Введите описание должности.", "error");
		}
	} else {
		$.notify("Введите должность.", "error");
	}
}