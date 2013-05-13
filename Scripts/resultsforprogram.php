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
$a_evaluadas = array(); // actividades que han sido evaluadas

// Se busca informacion de los cursos pertenecientes al programa
$courses_data = mysql_query("SELECT distinct codificacion, nombre_curso from Cursos where 
	prog_curso = '$prog_id';") or die(mysql_error());

// Si no se encontro ningun curso, generamos un error.
if (mysql_num_rows($courses_data) == 0) {
	$error = "There are no courses for this program.";
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

	$logrosesperados = array();	// Logros esperados
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
			$activity_data = mysql_query("SELECT distinct act_id, nombre_act, logro_esperado from Actividades
				natural join ActividadesCurso natural join Evaluacion where	curso_id='$cid';")
				or die(mysql_error());	

			$activity_counter[$cid] = mysql_num_rows($activity_data);

			if ($activity_counter > 0) {
				while ($result = mysql_fetch_array($activity_data)) {
			 		$a_evaluadas[] = $result["act_id"];
					$logrosesperados[] = $result["logro_esperado"];
				}
			}
		}

		foreach ($activity_counter as $qty) {
			$tabla1.= "<p>$qty</p>";
		}

		$tabla1.= "</td></tr>";	
	}
	$tabla1.="</tbody></table>";

 // Para las actividades que han sido evaluados
 for ($i = 0; $i < sizeof($a_evaluadas); $i++) {
	// Se obtiene el total de estudiantes evaluados en la actividad
	$query = mysql_query("SELECT distinct mat_id FROM Evaluacion WHERE act_id='$a_evaluadas[$i]';")
		or die(mysql_error());
	$estudiantes = mysql_num_rows($query);

	if ($estudiantes > 0) {

		// Se obtienen los ids y nombres de los criterios en la rubrica. 
		$query = mysql_query("SELECT crit_id, nombre_crit FROM RubricaLocal NATURAL 
			JOIN Actividades NATURAL JOIN Criterios WHERE act_id = '$a_evaluadas[$i]';")
			or die(mysql_error());

		$crit_qty = mysql_num_rows($query);

		// Verifica que hayan resultados
		if ($crit_qty > 0) {
			$cids = array();
			$criterios = array();

			while ($result = mysql_fetch_array($query)) {
				$cids[] = $result["crit_id"];
				$criterios[] = $result["nombre_crit"]; 
			}

		$totales = array(array());

		/* Se obtienen los totales para cada escala en la rubrica. */
		for($criterio=0; $criterio<$crit_qty; $criterio++) { // Criterios - Filas
			$totales[$criterio][9] = 0; // Retiene el total de estudiantes con 6 o mas.
			$totales[$criterio][11] = 0; // Para verificar si se han hecho evaluaciones o no.

			for ($escala=0; $escala<=8; $escala++) { // Escala - Columnas
	    		$query = mysql_query("Select count(ptos_obtenidos) from Evaluacion where 
					ptos_obtenidos=".$escala." && crit_id=".$cids[$criterio]." 
					&& act_id=".$a_evaluadas[$i].";") or die(mysql_error());
				if(mysql_num_rows($query) > 0) {
					$result = mysql_fetch_array($query);
					$totales[$criterio][$escala] = $result[0];
				} 
				else {
					$totales[$criterio][$escala] = 0;
				}		

				// Acumulador para detectar si el criterio fue evaluado.
				$totales[$criterio][11]+=$totales[$criterio][$escala];

				// Se generan los totales de estudiantes que obtuvieron 6 o mas.
				if ($escala >= 6) {
					$totales[$criterio][9]+=$totales[$criterio][$escala];
				}
			}
	
			$totales[$criterio][9] = (($totales[$criterio][9])/$estudiantes)*100;

			// Verificar si el criterio fue evaluado y de ser asi, si fue aprobado.
			if ($totales[$criterio][11] == 0) {
				$totales[$criterio][9] = 'x';
				$totales[$criterio][10] = 'Not evaluated';
			}
			else if ($totales[$criterio][9] >= $logrosesperados[$i]) {
				$totales[$criterio][10] = 'Achieved';
			}
			else $totales[$criterio][10] = 'Not achieved';
		} 
		// Copio los resultados que necesito de la tabla 2D a arreglos sencillos.
		for($k = 0; $k < $crit_qty; $k++) {
			$cr_aprobados[] = $totales[$k][10];
			$nombres_crs[] = $criterios[$k];
		}
	}
  }
 }

 /*--------------------- Genero tabla de resumen de criterios ---------------------*/
 if (sizeof($a_evaluadas)>0) {

  $criterios_norep = array_unique($nombres_crs);

  $tabla2 ="<br><br><br><br><table id = grading>
	 <caption><h4>Summary of criteria for evaluated activities.</h4>
	</caption>
	       <thead><td><p>Criterion</p></td>
	       <td><p>Numbers of times evaluated</p></td>
	       <td><p>Approved</p></td>
		   <td><p>Not approved</p></td>
		   </thead>
	    <tbody>"; 	

  $alcanzado = 0;	// Contador de veces que se alcanzo el criterio
  $noalcanzado = 0;	// Contador de veces que no se alcanzo

  /* Arreglos para retener data a utilizarse en agregados por dominio */
  $cr_evaluados = array();
  $total = array();
  $aprobado = array();

  foreach ($criterios_norep as $criterio) {
	// Criterio
	$tabla2.="<tr><td><p>".$criterio."</p></td>";
	$result = array_keys($nombres_crs, $criterio);  
	foreach ($result as $status) {
		if ($cr_aprobados[$status] == "Achieved") $alcanzado++;
		else if ($cr_aprobados[$status] == "Not achieved") $noalcanzado++;
	}

	$veces = $alcanzado + $noalcanzado; // Cuantas veces fue evaluado el criterio
	if ($veces == 0) {
		$veces = "Not evaluated";
		$alcanzado = "-";
		$noalcanzado = "-";
	}
	// Data para los agregados por dominio
	else {
		$cr_evaluados[] = $criterio;
		$aprobado[] = $alcanzado;
		$total[] = $veces; 	
	}

	// Veces que se evaluo
	$tabla2.="<td><p>".$veces."</p></td>";
	// Alcanzado
	$tabla2.="<td><p>".$alcanzado."</p></td>";
	// No alcanzado
	$tabla2.="<td><p>".$noalcanzado."</p></td>";			
	$tabla2.="</tr>";

	$alcanzado = 0;
	$noalcanzado = 0;
  }
  $tabla2.="</tbody></table>";

 }
 else {
  $tabla2 = "<p><br><br>To show aggregates, there must be at least one evaluated activity<br>";
 }

 /*--------------------- Genero tabla de criterios alineados a dominios ---------------------*/ 
 $dominios = array(); // Tabla para retener relacion "dominio" => "cr1","cr2",...
 $cont_dom = 0; // Retiene la cantidad de dominios distintos

 if (sizeof($a_evaluadas) > 0) { // Si hay actividades evaluadas...
  foreach ($cr_evaluados as $criterio) {
	// Relaciono dominios con criterios
	$query = mysql_query("Select nombre_dom from Dominios natural join CriterioPertenece
		where crit_id in (Select crit_id from Criterios where nombre_crit='$criterio');")
	 	or die(mysql_error());

	// Verifica que hayan resultados
	if (mysql_num_rows($query) > 0) {
		while ($result = mysql_fetch_array($query)) {
			$dom = $result["nombre_dom"];				
			$dominios[$dom][] = $criterio;
		}
	}
  }

  // Se comienza a generar la tabla  
  $tabla3 = "<br><br><br><br><table id = grading>
	 <caption><h4>Aggregates by domain for course</h4>
	</caption>
	       <thead>
		   <td><p>Domains</p></td>
	       <td><p>Criteria aligned</p></td>
	       <td><p>Criteria achieved</p></td>
   		   <td><p>Percentage</p></td>
		   <td><p>Achieved or not achieved</p></td>
		   </thead>
	    <tbody>"; 	

  foreach ($dominios as $dom => $lista_criterios) { 
	$apr = 0;	// Contador de criterios alineados aprobados
	$tot = 0;	// Contador del total de criterios alineados evaluados
	$tabla3.="<tr>";
 	if ($span = sizeof($lista_criterios) != 0) {
		// Despliego nombre del dominio
		$tabla3.= "<td rowspan = $span><p> $dom </p></td>";
		$tabla3.= "<td>";
			/* Despliego criterios alineados y verifico cuantas veces se aprobaron
			   y el total de veces que fueron evaluados. */
			foreach($lista_criterios as $criterio) {
        		$tabla3.= "<p> $criterio </p>";
				$key = array_search($criterio, $cr_evaluados);
				$apr += $aprobado[$key];
				$tot += $total[$key];
			}
		$tabla3.= "</td>";
		$tabla3.= "<td rowspan = $span><p> $apr de $tot </p></td>
		   		   <td rowspan = $span><p>".round(($apr/$tot)*100,2)."</p></td>";
			// Si el porcentaje es mayor que 70, se alcanzo.
			if (round(($apr/$tot)*100,2) > 70) {
				$tabla3.= "<td rowspan = $span><p> Achieved </p></td>";
			}
			else {
				$tabla3.= "<td rowspan = $span><p> Not achieved </p></td>";
			}						
 	}
	$tabla3.="</tr>";
  }	
  $tabla3.="</tbody></table>";

 } // Termina if actividades evaluadas
 else {
	$tabla3 = "";
 }

}

?>

<div id='content'> 
	<center>

	<h3> Results for <?echo $prog_id;?> program</h3>
	<? if (!isset($error))
		  if (isset($tabla1)) echo $tabla1;
		  if (isset($tabla2)) echo $tabla2;
		  if (isset($tabla3)) echo $tabla3;
		else
			echo $error;
	?>

	<br><br><br><br><br></center>
</div>
