function changeFont(id, action) {
	if(action === 1) {
		document.getElementById(id).style.color = "#ff282b";
		document.getElementById(id).style.textDecoration = "none";
	} else {
		document.getElementById(id).style.color = "#4c4c4c";
		document.getElementById(id).style.textDecoration = "underline";
	}
}