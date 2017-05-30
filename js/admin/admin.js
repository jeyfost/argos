$(window).on("load", function() {
	if($('#menu').height() < $(window).height()) {
		$('#menu').height($(window).height());
	}

	$('#content').width(parseInt($(window).width() - $('#menu').width() - 20));
	$('#admContent').width(parseInt($(window).width() - 340));

	if($('table').width() > $('#admContent').width()) {
		$('#admContent').width($('table').width());
		$('#top').width($('table').width());
	}

	if($('#goodsTable').length) {
		if($('#addForm').length) {
			if($('#goodsTable').width() > parseInt($('#admContent').width() - $('#addForm').width())) {
				$('#goodsTable').width(parseInt($('#admContent').width() - $('#addForm').width() - 100));
			}
		}

		if($('#editForm').length) {
			if($('#goodsTable').width() > parseInt($('#admContent').width() - $('#editForm').width())) {
				$('#goodsTable').width(parseInt($('#admContent').width() - $('#editForm').width() - 100));
			}
		}

		if($('#deleteForm').length) {
			if($('#goodsTable').width() > parseInt($('#admContent').width() - $('#deleteForm').width())) {
				$('#goodsTable').width(parseInt($('#admContent').width() - $('#deleteForm').width() - 100));
			}
		}
	}
});

function changeIcon(id, img, depth) {
	var d = "";

	for(var i = 0; i < depth; i++) {
		d += "../";
	}

    document.getElementById(id).src = d + "img/system/" + img;
}