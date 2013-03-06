

$(document).ready(function() {

	var h = $(window).height(); 

	$("#nav_drop").css("height", h);
	$("#main_sub").css("height", h);
	$("#main_content").css("height", h);

// Esta funcion cuando hacen click en la imagen abre y cierra el nav_drop
	$('#show_hide').click(function() {

	  $('#nav_drop').animate({
		    //-webkit-box-flex: 0,
		    width: 'toggle',
		  }, 500, function() {
		  			
		    // Animation complete.
 		});

	});


	$("#thumb1").on("click", function() {
		//remove/fadeout el content
		//append spinner
		$.get("http://emmy2.ccom.uprrp.edu/~asantos/Front-end/ruta.php", function(html){
			//remove/fadeout el spinner
			//append html
			$("#content").hide()
			$("#content").replaceWith(html)
			console.log(html)
		})
	});

	$("#thumb2").on("click", function() {
		//remove/fadeout el content
		//append spinner
		$.get("http://emmy2.ccom.uprrp.edu/~asantos/Front-end/ruta.php", function(html){
			//remove/fadeout el spinner
			//append html
			$("#content").hide()
			$("#content").replaceWith(html)
			console.log(html)
		})
	});

	$("#thumb3").on("click", function() {
		//remove/fadeout el content
		//append spinner
		$.get("http://emmy2.ccom.uprrp.edu/~asantos/Front-end/ruta.php", function(html){
			//remove/fadeout el spinner
			//append html
			$("#content").hide()
			$("#content").replaceWith(html)
			console.log(html)
		})
	});


});


 