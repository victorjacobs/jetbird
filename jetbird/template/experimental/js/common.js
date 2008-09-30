function set_height() {
	if($("#content").height() < $(window).height() - 35){
		$("#contentwrap").height($(window).height() - 35);
	}
}

$(window).resize(function() {
	set_height();
});

$(document).ready(function() {
	set_height();
	$("input").one("keydown", function() {
		$(".error").fadeOut(1000);
	});
});