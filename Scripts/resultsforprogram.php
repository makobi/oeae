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
$cids = array();	// ids de los cursos
$codifs = array();	// codificaciones

// Se busca informacion de los cursos pertenecientes al programa
$courses_data = mysql_query("SELECT distinct codificacion, nombre_curso, curso_id from Cursos where 
	prog_curso = '$prog_id';") or die(mysql_error());

// Si no se encontro ningun curso, generamos un error.
if (mysql_num_rows($courses_data) == 0) {
	$error = "No hay cursos asociados a ese programa.";
}
else { // Si hay cursos...
	while ($result = mysql_fetch_array($courses_data)) {
		$cids[] = $result['curso_id'];
		$nombres_cursos[] = $result['nombre_curso'];
		$codifs[] = $result["codificacion"];
	}

	$logrosesperados = array(array());	// Logros esperados
	$actividades = array(array());	 	// Ids de las actividades
	$nombresact = array(array());		// Nombres de la actividades

	foreach ($cids as $key => $curso_id) {
		// Se obtiene data de las actividades asociadas a cada curso. 
		$activity_data = mysql_query("SELECT act_id, nombre_act, logro_esperado from Actividades natural join 
			ActividadesCurso where curso_id='$curso_id';")
			or die(mysql_error());

		// Si no hay actividades, removemos el curso del arreglo.
		if (mysql_num_rows($activity_data) == 0) {
			unset($cids[$key]);
			unset($nombres_cursos[$key]);
			unset($codifs[$key]);
		}
		else { // Si hay actividades, almacenamos su data en arreglos relacionados con su id de curso. 
			while ($result = mysql_fetch_array($activity_data)) {
			 	$actividades[$curso_id][] = $result["act_id"];
				$nombresact[$curso_id][] = $result["nombre_act"];
				$logrosesperados[$curso_id][] = $result["logro_esperado"];
			}


			$a_evaluadas = array(array());	// Retendra ids las actividades que fueron evaluadas
//			$nombres_crs = array(array()); 	// Nombres de los criterios de todas las actividad
//			$cr_aprobados = array(array());	// Indica si se aprobo o no cada criterio en $nombre_crs

			// Query para verificar que actividades han sido evaluadas
			$eval_data = mysql_query("Select distinct act_id from Actividades natural join ActividadesCurso
				natural join Evaluacion where curso_id ='$curso_id';") or die(mysql_error());

			if (mysql_num_rows($eval_data) > 0) { // Si hay actividades evaluadas...
				while ($result = mysql_fetch_array($eval_data)) {
 					$a_evaluadas[$curso_id][] = $result["act_id"];
				}
 			}
		}
	} // end foreach
	
	/* Generamos tabla con resumen de actividades para los cursos - Incluye los curso, nombres
	de las actividades, su logro esperado y si estas han sido evaluadas o no */
	$tabla1 ="<table id = grading>
		<caption><h4> Summary of Courses </h4></caption>
        <thead>
		<td><p> Courses </p></td>
		<td><p> Course Names </p></td>
		<td><p> Activities </p></td>
        <td><p> Expected Outcomes </p></td>
        <td><p> Status </p></td>
	    </thead>
    <tbody>"; 

	foreach ($cids as $i => $cursoID) {
		$tabla1.="<tr><td><p>".$codifs[$i]."</p></td>
					  <td><p>".$nombres_cursos[$i]."</p></td>";
		if (in_array($actividades[$cursoID][] ,array_diff($actividades, $a_evaluadas)))
		foreach ($actividades as $cid => $actividad) {
			
		}
				 
	}
	
/*
		 for ($i = 0; $i < sizeof($actividades); $i++) {
			$tabla1.="<tr><td><p>".$nombresact[$i]."</p></td>
 				  <td><p>".$logrosesperados[$i]."</p></td>";
			if (in_array($actividades[$i] ,array_diff($actividades, $a_evaluadas))) {
				$tabla1.="<td><p>No evaluada</p></td>";
			}
			else {
				$tabla1.="<td><p>Evaluada</p></td>";		
			}
			$tabla1.="</tr>";
		}
*/		$tabla1.="</tbody></table>";
}

?>

<div id='content'> 
	<center>

	<h3> Results for <?echo $prog_id;?> program</h3>


	</center>
</div>
