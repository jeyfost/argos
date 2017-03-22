$(window).on("load", function() {
	$(".yearFont").mouseover(function() {
		$(this).css("text-decoration", "none");
		$(this).css("color", "#df4e47");
	});

	$(".yearFont").mouseout(function() {
		$(this).css("text-decoration", "underline");
		$(this).css("color", "#4c4c4c");
	});
});

function changeFont(id, action) {
	if(action == 1) {
		document.getElementById(id).style.color = "#df4e47";
		document.getElementById(id).style.textDecoration = "none";
	} else {
		document.getElementById(id).style.color = "#4c4c4c";
		document.getElementById(id).style.textDecoration = "underline";
	}
}