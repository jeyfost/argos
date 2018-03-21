/**
 * Created by jeyfost on 30.03.2017.
 */

function addAlbum() {
	var name = $('#nameInput').val();

	if(name !== '') {
		$.ajax({
			type: "POST",
			data: {"name": name},
			url: "/scripts/admin/albums/ajaxAddAlbum.php",
			success: function (response) {
				switch(response) {
					case "ok":
						$.notify("Альбом был успешно добавлен.", "success");
						break;
					case "failed":
						$.notify("Во время добавления альбома произошла ошибка.", "error");
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