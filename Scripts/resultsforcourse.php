<?php
/*
	Tahiri Laboy De Jesus
	Script para ver agregados por curso - Recibe por el id del curso.
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

$curso_id = $_GET['course_id'];
$_SESSION['course_id'] = $curso_id;


$query = "SELECT codificacion, nombre_curso from Cursos where curso_id=".$curso_id;
$result = mysql_fetch_array(mysql_query($query));
$codif = $result[0];
$nombre_curso = $result[1];

$logrosesperados = array(); // Logros esperados
$actividades = array(); 		// Ids de las actividades
$nombresact = array();		// Nombres de la actividades

/* Se obtienen los logros esperados para cada actividad asociada a un curso. */
$query = mysql_query("SELECT act_id, nombre_act, logro_esperado from Actividades natural join 
	ActividadesCurso where curso_id='$curso_id';")
	or die(mysql_error());

/************************ SI HAY ACTIVIDADES... ************************/
if (mysql_num_rows($query)>0) { 

 while ($result = mysql_fetch_array($query)) {
 	$actividades[] = $result["act_id"];
	$nombresact[] = $result["nombre_act"];
	$logrosesperados[] = $result["logro_esperado"];
 } 

 $i = 0;

 $a_evaluadas = array();	// Retendra ids las actividades que fueron evaluadas
 $nombres_crs = array(); 	// Nombres de los criterios de todas las actividad
 $cr_aprobados = array();	// Indica si se aprobo o no cada criterio en $nombre_crs

 // Query para verificar que actividades han sido evaluadas
 $query = mysql_query("Select distinct act_id from Actividades natural join ActividadesCurso
	natural join Evaluacion where curso_id ='$curso_id';") or die(mysql_error());
 if (mysql_num_rows($query)>0) { // Si hay actividades evaluadas...
 	while ($result = mysql_fetch_array($query)) {
 		$a_evaluadas[] = $result["act_id"];
	}
 }

 echo "<div id='content'><center>
	  <h3>Resultados para curso ".$codif." (".$nombre_curso.")</h3>
	  <a href=../Front-end/coursechart.php>Ver Graficas para estos resultados</a>";

 /* Se genera tabla con resumen de actividades para el curso - Incluye los nombres
	de las actividades, su logro esperado y si estas han sido evaluadas o no */
 $tabla1 ="<table id = grading>
	 <caption><h4>Resumen de actividades</h4>
	</caption>
	       <thead><td><p>Nombre de la actividad</p></td>
	       <td><p>Logro Esperado</p></td>
	       <td><p>Evaluada o no evaluada</p></td>
		   </thead>
	    <tbody>"; 	

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
				$totales[$criterio][10] = 'No evaluado';
			}
			else if ($totales[$criterio][9] >= $logrosesperados[$i]) {
				$totales[$criterio][10] = 'Alcanzado';
			}
			else $totales[$criterio][10] = 'No alcanzado';
		} 
		// Copio los resultados que necesito de la tabla 2D a arreglos sencillos.
		for($k = 0; $k < $crit_qty; $k++) {
			$cr_aprobados[] = $totales[$k][10];
			$nombres_crs[] = $criterios[$k];
		}
	}
  }
}

$criterios_norep = array_unique($nombres_crs);

/*--------------------- Genero tabla de resumen de criterios ---------------------*/
if (sizeof($a_evaluadas)>0) {
 $tabla2 ="<br><br><br><br><table id = grading>
	 <caption><h4>Resumen de criterios para actividades evaluadas</h4>
	</caption>
	       <thead><td><p>Criterio</p></td>
	       <td><p>Veces que se evaluó</p></td>
	       <td><p>Aprobado</p></td>
		   <td><p>No aprobado</p></td>
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
		if ($cr_aprobados[$status] == "Alcanzado") $alcanzado++;
		else if ($cr_aprobados[$status] == "No alcanzado") $noalcanzado++;
	}

	$veces = $alcanzado + $noalcanzado; // Cuantas veces fue evaluado el criterio
	if ($veces == 0) {
		$veces = "No evaluado";
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
 $tabla2 = "<p><br><br>Para ver resultados por criterios debe evaluar al menos una actividad.<br>";
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
	 <caption><h4>Agregados por dominios para el curso</h4>
	</caption>
	       <thead>
		   <td><p>Dominios</p></td>
	       <td><p>Criterios alineados</p></td>
	       <td><p>Criterios alcanzados</p></td>
   		   <td><p>Porciento</p></td>
		   <td><p>Alcanzado o no alcanzado</p></td>
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
				$tabla3.= "<td rowspan = $span><p> Alcanzado </p></td>";
			}
			else {
				$tabla3.= "<td rowspan = $span><p> No alcanzado </p></td>";
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
/************************ SI NO HAY ACTIVIDADES... ************************/
else {
	$tabla2 ="<p> Error: Aún no se han realizado actividades para este curso.";
} 

echo $tabla1.$tabla2.$tabla3;
echo "<br><br><br><br><br><br></center></div>";

?>
