/**
 * Created by jeyfost on 31.03.2017.
 */

function deleteAward() {
	if(confirm("Вы действительно хотите удалить эту награду?")) {
		var formData = new FormData($('#deleteForm').get(0));

		$.ajax({
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			url: "/scripts/admin/achievements/ajaxDeleteAward.php",
			success: function(response) {
				switch(response) {
					case "ok":
						$.notify("Награда была успешно удалена.", "success");
						break;
					case "failed":
						$.notify("Во время удаления награды произошла ошибка.", "error");
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
	}
}