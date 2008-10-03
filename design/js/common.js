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

$(window).resize(function() {
	set_height();
});

$(document).ready(function() {
	set_height();
	$("input#search").attr("value", "Search").css("color", "gray");
	$("#projects > ul").hide();
	
	$("input#search").blur(function() {
		if($(this).attr("value") == ""){
			$(this).attr("value", "Search").css("color", "gray");
		}
	});
	
	$("input#search").focus(function() {
		if($(this).attr("value") == "Search"){
			$(this).attr("value", "");
		}
		if($(this).css("color") == "gray"){
			$(this).css("color", "black");
		}
	});
	
	$("form").one("keydown", function() {
		setTimeout('$(".error").fadeOut(1000)', 1000);
	});
	
	$("#sidewrap a").click(function() {
		$("#content").fadeOut(800, function() {
			$(this).load("./AJAXdata");
			$(this).fadeIn(800);
		});
	});
	
	$("div#projects").hover(function() {
		$("#projects > ul").show(500);
	}, function() {
		setTimeout('$("#projects > ul").hide(500)', 2000);
	});
	
	$("div#projects").click(function() {
		$("#projects > ul").toggle(500);
	});
});