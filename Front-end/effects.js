

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
		$.get("http://emmy2.ccom.uprrp.edu/~asantos/Front-end/ruta.php?act_id=1", function(html){
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

	// Magia oscura! Las actividades renderean una tabla con el nombre de la actividad arriba onClick
	$(".actividades").on("click", function() {

		var name = $(this).find('p').text();
		var id = $(this).find('p').attr('id');

		var url = "http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/viewcourse.php?nombre_act="+name+"&act_id="+id;

		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	$("#profile").on("click", function () {
		$.get("http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/profile.php", function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});


});


 