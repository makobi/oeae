<?php

/*
	resultsby.php
	Permite al usuario (administrador) seleccionar que tipo de agregados desea ver.
	De acuerdo al tipo seleccionado (facultad, programa o curso), se procesa en listby.php
	una lista para seleccionar el agregado.
*/

session_start();

/* Parametros para conexion a la base de datos */
$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

/* Se intenta la conexion, de ser infructuosa se deniega el acceso. */
if ($link) {
	mysql_select_db("Avaluo");
} 
else {
	echo "Access Denied!";
	exit();
}

?>
 
<script type='text/javascript'>
	// Funcion que genera el url donde se genera la lista por tipo
	function ResultsListByType(type) {
		url = '../Scripts/listby.php?type='+type;
		$.get(url, function(html) {
			$('#content').hide()
			$('#content').replaceWith(html)
		})
	};
</script>

<div id='content'> 
	<center>

	<h2> Show results by: </h2> <br> <br>	

	<h3>
		<!-- <a href='#' onClick='ResultsListByType("college")'> College or School </a><br><br> -->
		<a href='#' onClick='ResultsListByType("program")'> Program </a><br><br>
		<a href='#' onClick='ResultsListByType("course")'> Course </a><br><br>
	</h3>

	</center>
</div>
