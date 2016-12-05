$(window).on('load', function() {
	if($('div').is('#pbPrev') && $('div').is('#pbNext')) {
		var blockWidth = parseInt($('#pbNext').offset().left + $('#pbNext').width() - $('#pbPrev').offset().left + 40);
		$('#pageNumbers').width(blockWidth);
	}
});

function categoryStyle(action, img, text, imgBlack, imgRed) {
	if(action == 1) {
		document.getElementById(text).style.color = "#df4e47";
		document.getElementById(img).src = "img/icons/" + imgRed;
	} else {
		document.getElementById(text).style.color = "#4f4f4f";
		document.getElementById(img).src = "img/icons/" + imgBlack;
	}
}

function subcategoryStyle(action, id) {
	if(action == 1) {
		document.getElementById(id).style.color = "#df4e47";
	} else {
		document.getElementById(id).style.color = "#4f4f4f";
	}
}

function pageBlock(action, block, text) {
	if(action == 1) {
		document.getElementById(block).style.backgroundColor = "#df4e47";
		document.getElementById(text).style.color = "#fff";
	} else {
		document.getElementById(block).style.backgroundColor = "#fff";
		document.getElementById(text).style.color = "#df4e47";
	}
}