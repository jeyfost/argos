function awardBlock(text, photo, action) {
	if(action == 1) {
		document.getElementById(text).style.color = "#df4e47";
		document.getElementById(photo).style.opacity = ".7";
	} else {
		document.getElementById(text).style.color = "#4c4c4c";
		document.getElementById(photo).style.opacity = "1";
	}
}