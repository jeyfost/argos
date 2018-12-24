/**
 * Created by jeyfost on 07.04.2017.
 */

function pageBlock(action, block, text) {
	if(action === 1) {
		document.getElementById(block).style.backgroundColor = "#ff282b";
		document.getElementById(text).style.color = "#fff";
	} else {
		document.getElementById(block).style.backgroundColor = "#fff";
		document.getElementById(text).style.color = "#ff282b";
	}
}

function searchClient() {
	var searchInput = $('#searchInput');
	var search = searchInput.val();
	var searchList = $('#searchList');

	if(search !== '') {
		$.ajax({
			type: "POST",
			data: {"search": search},
			url: "/scripts/admin/clients/ajaxSearchInactive.php",
			success: function(response) {
				var x = parseInt(searchInput.offset().left);
				var y = parseInt(searchInput.offset().top + 40);

				searchList.offset({top: y, left: x});

				searchList.html(response);
				searchList.show('300');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	} else {
		searchList.hide('300');

		setTimeout(function() {
			searchList.html('');
		}, 300)
	}
}

function searchItemHover(id, action, parameter) {
	if(action === 1) {
		$('#' + id).css('background-color', '#c0cdd6');
	} else {
		if(parameter % 2) {
			$('#' + id).css('background-color', '#fff');
		} else {
			$('#' + id).css('background-color', '#d9d9d9');
		}
	}
}

function searchBlur() {
	$('#searchList').hide('300');

	setTimeout(function() {
		$('#searchList').html('');
	}, 300);
}

function returnClient(id) {
	if(confirm("Вы действительно хотите вернуть клиента в список рассылки?")) {
		$.ajax({
			type: "POST",
			data: {"id": id},
			url: "/scripts/admin/clients/ajaxReturnClient.php",
			success: function (response) {
				switch(response) {
					case "ok":
						$.notify("Клиент успешно возвращён в список рассылки.", "success");
						break;
					case "failed":
						$.notify("Произошла ошибка. Попробуйте снова.", "error");
						break;
					case "client":
						$.notify("Клиента с таким ID не существует.", "error");
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