$(window).on("load", function() {
	if($('div').is('.catalogueIMG')) {
		$('.catalogueIMG').mouseover(function() {
			$(this).children('.actionIMG').css("opacity", "1");
		});

		$('.catalogueIMG').mouseout(function() {
			$(this).children('.actionIMG').css("opacity", ".6");
		});
	}
});

function buttonChange(id, action) {
	if(action == 1) {
		document.getElementById(id).style.color = "#fff";
		document.getElementById(id).style.backgroundColor = "#df4e47";
	} else {
		document.getElementById(id).style.color = "#4c4c4c";
		document.getElementById(id).style.backgroundColor = "#dedede";
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

function textAreaHeight(textarea) {
    if (!textarea._tester) {
        var ta = textarea.cloneNode();
        ta.style.position = 'absolute';
        ta.style.zIndex = 2000000;
        ta.style.visibility = 'hidden';
        ta.style.height = '1px';
        ta.id = '';
        ta.name = '';
        textarea.parentNode.appendChild(ta);
        textarea._tester = ta;
        textarea._offset = ta.clientHeight - 1;
    }
    if (textarea._timer) clearTimeout(textarea._timer);
    textarea._timer = setTimeout(function () {
        textarea._tester.style.width = textarea.clientWidth + 'px';
        textarea._tester.value = textarea.value;
        textarea.style.height = (textarea._tester.scrollHeight - textarea._offset) + 'px';
        textarea._timer = false;
    }, 1);
}