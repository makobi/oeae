

$("div#show_hide").click(function () {
	var width = $("div#nav_drop").css("width");
	while(width != 0){
		width = width - 1;
	  $("div#nav_drop").css("width", width);
	}
});
 
