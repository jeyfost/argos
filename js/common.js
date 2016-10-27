function buttonChange(id, action) {
	if(action == 1) {
		document.getElementById(id).style.color = "#fff";
		document.getElementById(id).style.backgroundColor = "#df4e47";
	} else {
		document.getElementById(id).style.color = "#4c4c4c";
		document.getElementById(id).style.backgroundColor = "#dedede";
	}

}