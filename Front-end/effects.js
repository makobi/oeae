$(document).ready(function() {

// Esta funcion cuando hacen click en la imagen abre y cierra el nav_drop
	$('#show_hide').click(function() {

	  $('#nav_drop').animate({
		    //-webkit-box-flex: 0,
		    width: 'toggle',
		  }, 500, function() {
		  			
		    // Animation complete.
 		});
	  /*
	  $('#profile').animate({
		    //-webkit-box-flex: 0,
		    width: 'toggle',
		  	}, 700, function() {
		    	// Animation complete.
 	 	});

 	  $('#menu').animate({
		    //-webkit-box-flex: 0,
		    width: 'toggle',
		  	}, 700, function() {
		    	// Animation complete.
 	 	});
 	 */
	});
});


 