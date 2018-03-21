/**
 * Created by jeyfost on 29.03.2017.
 */

function deleteAction() {
	if(confirm("Вы действительно хотите удалить данную акцию?")) {
		var formData = new FormData($('#deleteForm').get(0));

		$.ajax({
			type: "POST",
			url: "/scripts/admin/actions/ajaxDeleteAction.php",
			data: formData,
			dataType: "json",
			processData: false,
			contentType: false,
			success: function(response) {
				switch(response) {
					case "ok":
						$.notify("Акция была успешно удалена.", "success");
						break;
					case "failed":
						$.notify("Во время удаления акции произошла ошибка.", "error");
						break;
					case "goods":
						$.notify("Во время удаления товаров из акции произошла ошибка.", "error");
						break;
					case "failedGoodsOk":
						$.notify("Во время удаления акции произошла ошибка. Товары из акции были удалены.", "error");
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