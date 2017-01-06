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