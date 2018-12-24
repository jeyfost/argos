function selectCategory(type, category) {
	window.location = "delete.php?type=" + type + "&category=" + category;
}

function selectSubcategory(type, category, subcategory) {
	window.location = "delete.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory;
}

function selectSubcategory2(type, category, subcategory, subcategory2) {
	window.location = "delete.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2;
}

function deleteCategory() {
	var responseField = $("#responseField");
	var formData = new FormData($('#deleteForm').get(0));

	if(confirm("Вы действительно хотите удалить раздел?")) {
		$.ajax({
			type: 'POST',
			data: formData,
			dataType: "json",
			processData: false,
			contentType: false,
			url: "/scripts/admin/sections/ajaxDeleteCategory.php",
			beforeSend: function() {
				if(responseField.css('opacity') === 1) {
					responseField.css('opacity', 0);
					setTimeout(function() {
						responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					responseField.css('color', '#ff282b');
					responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
					responseField.css('opacity', 1);
				}
			},
			success: function(response) {
				var s;
				var status;

				switch(response) {
					case "ok":
						s = 1;
						status = "Раздел был успешно удалён.";
						break;
					case "failed":
						s = 0;
						status = "При удалении раздела произошла ошибка.";
						break;
					case "okGoodsOk":
						s = 1;
						status = "Раздел был успешно удалён.";
						break;
					case "okGoodsPartly":
						s = 0;
						status = "при удалении произошла ошибка.<br />Раздел был удалён.<br /><b>Товары удалены частично.</b>";
						break;
					case "okGoodsFailed":
						s = 0;
						status = "При удалении прозишла ошибка.<br />Раздел был удалён.<br /><b>Товары не были удалены.</b>";
						break;
					case "failedGoodsOk":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br />Товары удалены.";
						break;
					case "failedGoodsPartly":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Товары удалены частично.</b>";
						break;
					case "failedGoodsFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.";
						break;
					case "okSubPartlyGoodsOk":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Подразделы удалены частично.</b><br />Товары удалены.";
						break;
					case "okSubPartlyGoodsPartly":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Подразделы удалены частично.</b><br /><b>Товары удалены частично.</b>";
						break;
					case "okSubPartlyGoodsFailed":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Подразделы удалены частично.</b><br /><b>Товары не удалены.</b>";
						break;
					case "okSubFailedGoodsOk":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Подразделы не удалены.</b><br />Товары удалены.";
						break;
					case "okSubFailedGoodsPartly":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Подразделы не удалены.</b><br /><b>Товары удалены частично.</b>";
						break;
					case "okSubFailedGoodsFailed":
						s = 0;
						status = "При удалении прозишла ошибка.<br /><b>Раздел не был удалён.</b><br /><b>Подразделы не удалены.</b><br /><b>Товары не удалены.</b>";
						break;
					case "okSubPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Раздел удалён.<br /><b>Подразделы удалены частично.</b>";
						break;
					case "okSubFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Раздел удалён.<br /><b>Подразделы не удалены.</b>";
						break;
					case "failedSubOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Раздел не удалён.</b><br />Подразделы удалены.";
						break;
					case "failedSubPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Раздел не удалён.</b><br /><b>Подразделы удалены частично.</b>";
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
							responseField.css('color', '#ff282b');
						}
						responseField.html("<br />" + status + "<br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					if(s === 1) {
						responseField.css('color', '#53acff');
					} else {
						responseField.css('color', '#ff282b');
					}
					responseField.html("<br />" + status + "<br />");
					responseField.css('opacity', 1);
				}
			}
		});
	}
}

function deleteSubcategory() {
	var responseField = $("#responseField");
	var formData = new FormData($('#deleteForm').get(0));

	if(confirm("Вы действительно хотите удалить подраздел?")) {
		$.ajax({
			type: 'POST',
			data: formData,
			dataType: 'json',
			contentType: false,
			processData: false,
			url: '/scripts/admin/sections/ajaxDeleteSubcategory.php',
			beforeSend: function() {
				if(responseField.css('opacity') === 1) {
					responseField.css('opacity', 0);
					setTimeout(function() {
						responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					responseField.css('color', '#ff282b');
					responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
					responseField.css('opacity', 1);
				}
			},
			success: function(response) {
				var s;
				var status;

				switch(response) {
					case "ok":
						s = 1;
						status = "Подраздел был успешно удалён.";
						break;
					case "failed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.";
						break;
					case "failedGoodsOk":
						s = 0;
						status = "При удплении подраздела произошла ошибка, однако все товары из него были удалены.";
						break;
					case "failedGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка, а также не все товары из него были удалены.";
						break;
					case "okGoodsPartly":
						s = 0;
						status = "Подраздел был успешно удалён, однако не все товары из него были удалены.";
						break;
					case "okGoodsFailed":
						s = 0;
						status = "Подраздел был успешно удалён, однако товары из него не были удалены.";
						break;
					case "okSubOkGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br />Дочерние подразделы удалены.<br /><b>Товары удалены не полностью.</b>";
						break;
					case "okSubOkGoodsFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br />Дочерние подразделы удалены.<br /><b>Товары не удалены.</b>";
						break;
					case "okSubPartlyGoodsOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br /><b>Дочерние подразделы удалены не полностью.</b><br />Товары удалены.";
						break;
					case "okSubPartlyGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br /><b>Дочерние подразделы удалены не полностью.</b><br /><b>Товары удалены не полностью.</b>";
						break;
					case "okSubPartlyGoodsFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br /><b>Дочерние подразделы удалены не полностью.</b><br /><b>Товары не удалены.</b>";
						break;
					case "okSubFailedGoodsOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br /><b>Дочерние подразделы не удалены.</b><br />Товары удалены.";
						break;
					case "okSubFailedGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br /><b>Дочерние подразделы не удалены.</b><br /><b>Товары удалены не полностью.</b>";
						break;
					case "okSubFailedGoodsFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br />Подраздел удалён.<br /><b>Дочерние подразделы не удалены.</b><br /><b>Товары не удалены.</b>";
						break;
					case "failedSubOkGoodsOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br />Дочерние подразделы удалены.<br />Товары удалены.";
						break;
					case "failedSubOkGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br />Дочерние подразделы удалены.<br /><b>Товары удалены не полностью.</b>";
						break;
					case "failedSubOkGoodsFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br />Дочерние подразделы удалены.<br /><b>Товары не удалены.</b>";
						break;
					case "failedSubPartlyGoodsOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы удалены не полностью.</b><br />Товары удалены.";
						break;
					case "failedSubPartlyGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы удалены не полностью.</b><br /><b>Товары удалены не полностью.</b>";
						break;
					case "failedSubPartlyGoodsFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы удалены не полностью.</b><br /><b>Товары не удалены.</b>";
						break;
					case "failedSubFailedGoodsOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы не удалены.</b><br />Товары удалены.";
						break;
					case "failedSubFailedGoodsPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы не удалены.</b><br /><b>Товары удалены не полностью.</b>";
						break;
					case "okPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел удалён.</b><br /><b>Дочерние подразделы удалены не полностью.</b>";
						break;
					case "okSubFailed":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел удалён.</b><br /><b>Дочерние подразделы не удалены.</b>";
						break;
					case "failedSubOk":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы удалены.</b>";
						break;
					case "failedPartly":
						s = 0;
						status = "При удалении подраздела произошла ошибка.<br /><b>Подраздел не удалён.</b><br /><b>Дочерние подразделы удалены не полностью.</b>";
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
							responseField.css('color', '#ff282b');
						}
						responseField.html("<br />" + status + "<br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					if(s === 1) {
						responseField.css('color', '#53acff');
					} else {
						responseField.css('color', '#ff282b');
					}
					responseField.html("<br />" + status + "<br />");
					responseField.css('opacity', 1);
				}
			}
		});
	}
}