$(window).on("load", function() {
	$(".yearFont").mouseover(function() {
		$(this).css("text-decoration", "none");
	});

	$(".yearFont").mouseout(function() {
		$(this).css("text-decoration", "underline");
	});
});