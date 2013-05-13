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

		var url = "../Scripts/viewcourse.php?nombre_act="+name+"&act_id="+id;

		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	$(".courseresults").on("click", function() {

		var id = $(this).find('p').attr('id');

		var url = "../Scripts/resultsforcourse.php?course_id="+id;

		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Información del perfil del profesor
	$("#profile").on("click", function () {
		$.get("../Scripts/profile.php", function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Crear una actividad nueva
	$(".newactivity").on("click", function() {
		var curso_id = $(this).attr("id");

		var url= "../Scripts/activity.php?curso_id="+curso_id ;

		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Añadir profesor(admin only)
	$(".prof").on("click", function() {
		url = "../Scripts/prof.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Crear Rubrica (admin only)
	$(".rub").on("click", function() {
		url = "../Scripts/createrubric.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});


	// Agregados para administrador
	$(".results").on("click", function() {
		url = "../Scripts/resultsby.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Crear Criterio (admin only)
	$(".addcrit").on("click", function() {
		url = "../Scripts/createcriterio.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Crear Criterio
	$(".editcrit").on("click", function() {
		url = "../Scripts/editcriterio.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Crear Dominio (admin only)
	$(".adddom").on("click", function() {
		url = "../Scripts/createdom.php";
		console.log("llegamos");
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Rubric Database
	$("#rdb").on("click", function() {
		url = "../Scripts/rubricdatabase.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Crear Rubrica local (Professor only)
	$("#create").on("click", function() {
		url = "../Scripts/createrubriclocal.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// Add a course
	$("#newcourse").on("click", function() {
		url = "../Scripts/newcourse.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	$("#managestudents").on("click", function() {
		url = "../Scripts/managestudents.php";
		$.get(url, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});

	// View Rubric from database
/*	$("#viewrubric").on("click", function(event) {
		event.preventDefault();
		$.get(this.href,{}, function(html) {
			$("#content").hide()
			$("#content").replaceWith(html)
		})
	});
*/
}); 
