/**
 * Created by jeyfost on 30.03.2017.
 */

function deleteAlbum() {
	var formData = new FormData($('#deleteForm').get(0));

	$.ajax({
		type: "POST",
		url: "../../scripts/admin/albums/ajaxCheckPhotos.php",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function(result) {
			var message;

			if(result === "no") {
				message = "Вы действительно хотите удалить альбом?";
			} else {
				message = "Вы действительно хотите удалить альбом? Фотографии из альбома будут безвозвратно удалены.";
			}

			if(confirm(message)) {
				$.ajax({
					type: "POST",
					url: "../../scripts/admin/albums/ajaxDeleteAlbum.php",
					data: formData,
					dataType: "json",
					processData: false,
					contentType: false,
					success: function(response) {
						switch(response) {
							case "ok":
								$.notify("Альбом был успешно удалён.", "success");
								break;
							case "failed":
								$.notify("Во время удаления альбома произошла ошибка.", "error");
								break;
							case "photos":
								$.notify("Во время удаления фотографий из альбома произошла ошибка.", "error");
								break;
							case "failedPhotosOk":
								$.notify("Во время альбома произошла ошибка. Фотографии из альбома были удалены.", "error");
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
	});
}