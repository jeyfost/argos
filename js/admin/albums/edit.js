/**
 * Created by jeyfost on 30.03.2017.
 */

function editAlbum() {
	var formData = new FormData($('#editForm').get(0));
	var name = $('#nameInput').val();

	if(name !== '') {
		$.ajax({
			type: "POST",
			data: formData,
			dataType: "json",
			processData: false,
			contentType: false,
			url: "../../scripts/admin/albums/ajaxEditAlbum.php",
			success: function (response) {
				switch(response) {
					case "ok":
						$.notify("Название альбома было успешно изменено.", "success");
						break;
					case "failed":
						$.notify("Во время редактирования альбома произошла ошибка.", "error");
						break;
					case "name":
						$.notify("Альбом с таким названием уже существует.", "error");
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
		$.notify("Введите название альбома.", "error");
	}
}