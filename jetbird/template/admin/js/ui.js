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
	if($("#content").height() < $(window).height() - 98 || $("#side").height() < $(window).height() - 98){
		$("#side").height($(window).height() - 98);
	}
}

$(window).resize(function() {
	set_height();
});

$(document).ready(function() {
	set_height();
	
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
								alert(returned_data);
							}
					});
				break;
				
				case "reindex":
					$(this).text("Please wait...");
					$.post(link + "search&reindex",
						{submit:"true", method:"ajax"},
						function(returned_data) {
							if(returned_data == "success"){
								location.reload();
							}else{
								alert(returned_data);
							}
					});
				break;
			}
		}
	});
});