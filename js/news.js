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