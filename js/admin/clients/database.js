/**
 * Created by jeyfost on 06.04.2017.
 */

function pageBlock(action, block, text) {
	if(action === 1) {
		document.getElementById(block).style.backgroundColor = "#df4e47";
		document.getElementById(text).style.color = "#fff";
	} else {
		document.getElementById(block).style.backgroundColor = "#fff";
		document.getElementById(text).style.color = "#df4e47";
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
			url: "../../scripts/admin/clients/ajaxSearch.php",
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