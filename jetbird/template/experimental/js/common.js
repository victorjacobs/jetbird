/*	This file is part of Jetbird.

    Jetbird is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Jetbird is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
*/

function set_height() {
	if($("#content").height() < $(window).height() - 35 && $("#sidewrap").height() < $(window).height() - 35){
		$("#contentwrap").height($(window).height() - 35);
	}
}

function ie6(){
	if(jQuery.browser.msie){
		if(jQuery.browser.version.substr(0, 1) == "6"){
			return true;
		}
	}
	return false;
}

$(window).resize(function() {
	set_height();
});

$(document).ready(function() {
	set_height();
	if(ie6()){
		// Since IE doesn't think the standards apply to them, force IE to display everthing right
		$("#footer").height(1);
		$("ul").css("margin", 0);
	}
	
	$(".needs_confirmation").click(function() {		// Need to finish this
		$(this).fadeOut(200, function() {
			$(this).text("Sure?");
			$(this).fadeIn();
		});		
	});
	
	$("form").one("keydown", function() {
		$(".error").fadeOut(1000);
	});
});