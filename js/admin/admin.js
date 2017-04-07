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
});

function changeIcon(id, img, depth) {
	var d = "";

	for(var i = 0; i < depth; i++) {
		d += "../";
	}

    document.getElementById(id).src = d + "img/system/" + img;
}