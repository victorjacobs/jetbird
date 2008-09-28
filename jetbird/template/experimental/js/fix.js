function bodyLoad(){
	var height = window.innerHeight - 35;
	if(document.getElementById("contentwrap").offsetHeight < height){
		document.getElementById("contentwrap").style.height = height + "px";
	}
}