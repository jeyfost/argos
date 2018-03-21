/**
 * Created by jeyfost on 03.04.2017.
 */

function deleteVacancy() {
	if(confirm("Вы действительно хотите закрыть вакансию?")) {
		var formData = new FormData($('#editForm').get(0));

		$.ajax({
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			url: "/scripts/admin/vacancies/ajaxDeleteVacancy.php",
			success: function(response) {
				switch(response) {
					case "ok":
						$.notify("Редактирование прошло успешно.", "success");
						break;
					case "failed":
						$.notify("Во время редактирования произошла ошибка.", "error");
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