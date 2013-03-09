

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

	$(".newactivity").on("click", function() {
		var curso_id = $(this).prev().attr("id");
		
		var url= "http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/activity.php?curso_id="+curso_id ;

		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

});


 