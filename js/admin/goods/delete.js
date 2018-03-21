function selectCategory(type, category) {
	window.location = "delete.php?type=" + type + "&category=" + category;
}

function selectSubcategory(type, category, subcategory) {
	window.location = "delete.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory;
}

function selectSubcategory2(type, category, subcategory, subcategory2) {
	window.location = "delete.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2;
}

function selectGood(type, category, subcategory, subcategory2, id) {
	window.location = "delete.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2 + "&id=" + id;
}

function deleteGood() {
	if(confirm("Вы действительно хотите удалить выбранный товар?")) {
		var responseField = $('#responseField');
		var goodID = $('#goodSelect').val();

		$.ajax({
			type: "POST",
			data: {"goodID": goodID},
			url: "/scripts/admin/goods/ajaxDeleteGood.php",
			beforeSend: function() {
				if(responseField.css('opacity') === 1) {
					responseField.css('opacity', 0);
					setTimeout(function() {
						responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					responseField.css('color', '#df4e47');
					responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
					responseField.css('opacity', 1);
				}
			},
			success: function(response) {
				var s = 0;
				var status;

				switch(response) {
					case "ok":
						s = 1;
						status = "Товар был успешно удалён.";
						break;
					case "failed":
						status = "Во времяы удаления товара произошла ошибка.";
						break;
					default:
						status = response;
						break;
				}

				if(responseField.css('opacity') === 1) {
					responseField.css('opacity', 0);
					setTimeout(function() {
						if(s === 1) {
							responseField.css('color', '#53acff');
						} else {
							responseField.css('color', '#df4e47');
						}
						responseField.html("<br />" + status + "<br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					if(s === 1) {
						responseField.css('color', '#53acff');
					} else {
						responseField.css('color', '#df4e47');
					}
					responseField.html("<br />" + status + "<br />");
					responseField.css('opacity', 1);
				}
			},
			error: function( xhr, textStatus ) {
				alert( [ xhr.status, textStatus ] );
			}
		});
	}
}