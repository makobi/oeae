<?php
/*
	Tahiri Laboy De Jesus
	Script para ver todas las rubricas
*/

/* Parametros para conexion a la base de datos */
$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

/* Se intenta la conexion, de ser infructuosa se deniega el acceso. */
if ($link) {
	mysql_select_db("Avaluo");
} else {
	echo "Access Denied!";
	exit();
}

// Funciones en JS
/* ViewRubric(rubricID) - Muestra la rubrica seleccionada por el usuario
   invocando el script view_rubric.php */
$content = "<script type='text/javascript'>
		function ViewRubric(rubricID) {
			url = '../Scripts/view_rubric.php?rub_id='+rubricID;
			$.get(url, function(html) {
				$('#content').hide()
				$('#content').replaceWith(html)
			})
		}
	  </script>";
	
$nombresrubricas = array();

// Se generan todos los nombres de las rubricas
$query = mysql_query("SELECT * FROM NombresRubricas ORDER BY nombre_rub;")
	or die(mysql_error());
while($result = mysql_fetch_array($query)) {
	$nombresrubricas[] = $result["nombre_rub"];
	$rubids[] = $result["rub_id"];
}

// Se comienza a desplegar el contenido
$content = $content."<div id='content'> <center>
	<p> Rubric Database
	<p> Choose one of the rubrics:<br>";

// Se muestran enlaces a todas las rubricas en la base de datos
for ($i = 0; $i < mysql_num_rows($query); $i++) {
	$content = $content. "<a href='#' onClick='ViewRubric(".$rubids[$i].")'>".$nombresrubricas[$i]."</a><br>";
}

$content = $content. "
	 </center></div>";

echo $content;
?>
