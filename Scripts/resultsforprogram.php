<?php
/*
	Tahiri Laboy De Jesus
	Script para ver agregados por programa - Recibe el nombre del programa.
	Genera tablas de actividades por curso, criterios evaluados y dominios.
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

session_start();

$prog_id = $_GET['prog_id'];
//$_SESSION['prog_id'] = $prog_id;

$nombres_cursos = array();
//$cids = array();	// ids de los cursos
$codifs = array();	// codificaciones

// Se busca informacion de los cursos pertenecientes al programa
$courses_data = mysql_query("SELECT distinct codificacion, nombre_curso from Cursos where 
	prog_curso = '$prog_id';") or die(mysql_error());

// Si no se encontro ningun curso, generamos un error.
if (mysql_num_rows($courses_data) == 0) {
	$error = "No hay cursos asociados a ese programa.";
}
else { // Si hay cursos...
	while ($result = mysql_fetch_array($courses_data)) {
		$nombres_cursos[] = $result['nombre_curso'];
		$codifs[] = $result["codificacion"];
	}

	/* Generamos tabla con resumen de actividades para los cursos - Incluye los curso, nombres
	de las actividades, su logro esperado y si estas han sido evaluadas o no */
	$tabla1 ="<table id = grading>
		<caption><h4> Summary of Courses </h4></caption>
        <thead>
		<td><p> Course </p></td>
		<td><p> Code </p></td>
		<td><p> Section </p></td>
        <td><p> Assessed Activities </p></td>
"/*        <td><p> Status </p></td>
*/."	    </thead>
    <tbody>"; 

	$logrosesperados = array(array());	// Logros esperados
	$actividades = array(array());	 	// Ids de las actividades
	$nombresact = array(array());		// Nombres de la actividades
	
	// Para cada curso
	foreach ($codifs as $key => $codificacion) {
		$tabla1.= "<tr><td><p>$nombres_cursos[$key]</p></td>
				   <td><p>$codifs[$key]</p></td>";
					
		$activity_counter = array();
		$ids_criterios = array();
		$secc_cell = "<td>";
		
		// Se obtiene data de las secciones asociadas a cada curso 
		$sections_data = mysql_query("SELECT curso_id, seccion from Cursos where codificacion='$codificacion';")
			or die(mysql_error());
		
		while ($result = mysql_fetch_array($sections_data)) {
			$cids[$codificacion][] = $result["curso_id"];
			$ids_criterios[] = $result["curso_id"];
		 	$secciones[$codificacion][] = $result["seccion"];

			// Retiene el listado de secciones asociado al curso
			$secc_cell .= ("<p>".$result["seccion"]."</p>"); 
		
			$tabla1.=$secc_cell;
		}

		$tabla1.="</td><td>";

		foreach ($ids_criterios as $cid) {

			$activity_counter[$cid] = 0;
		
			// Se obtiene data de las actividades evaluadas asociadas a cada curso. 
			$activity_data = mysql_query("SELECT distinct act_id, nombre_act, logro_esperado
				from Actividades natural join ActividadesCurso natural join Evaluacion where
				curso_id='$cid';")
				or die(mysql_error());	

			$activity_counter[$cid] = mysql_num_rows($activity_data);
		}

		foreach ($activity_counter as $qty) {
			$tabla1.= "<p>$qty</p>";
		}

		$tabla1.= "</td></tr>";
	}
	$tabla1.="</tbody></table>";
}

?>

<div id='content'> 
	<center>

	<h3> Results for <?echo $prog_id;?> program</h3>
	<? if (!isset($error))
			echo $tabla1;
		else
			echo $error;
	?>

	</center>
</div>
