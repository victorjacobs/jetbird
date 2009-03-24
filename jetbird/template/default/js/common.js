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

function ie6(){
	if(jQuery.browser.msie){
		if(jQuery.browser.version.substr(0, 1) == "6"){
			return true;
		}
	}
	return false;
}

$(document).ready(function() {
	$("input#search").attr("value", "Search").css("color", "gray");
	
	if(ie6()){
		// Since IE doesn't think the standards apply to them, force IE to display everthing right
		$("#footer").height(1);
		$("ul").css("margin", 0);
	}
	
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
	
	$(".needs_confirmation").click(function() {
		if($(this).text() != "Sure?"){
			$(this).fadeOut(200, function() {
				$(this).text("Sure?");
				$(this).fadeIn();
			});
		}else{
			var mode = $(this).attr("name").split("_");
			var id = mode[2];
			if(location.pathname.match("admin") != "admin"){
				var link = "./admin/?";
			}else{
				var link = "./?";
			}
			
			switch(mode[0]){
				case "del":
					$.post(link + mode[1] + "&delete",
						{submit:"true", id:id, method:"ajax"},
						function(returned_data) {
							if(returned_data == "success"){
								location.reload();
							}else{
								
							}
					});
				break;
			}
		}
	});
	
	$("form").one("keydown", function() {
		$(".error").fadeOut(1000);
	});
});