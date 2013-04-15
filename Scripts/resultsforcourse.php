<?php
/*
	Tahiri Laboy De Jesus
	Script para ver agregados por curso
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

//session_start();

$curso_id = 1;// $_SESSION['curso_id'];

$logrosesperados = array();
$act_ids = array(); 


/* Se obtienen los logros esperados para cada actividad asociada a un curso. */
$query = mysql_query("SELECT act_id, logro_esperado from Actividades natural join 
	ActividadesCurso where curso_id='$curso_id';")
	or die(mysql_error());

while ($result = mysql_fetch_array($query)) {
	$act_ids[] = $result["act_id"];
	$logrosesperados[] = $result["logro_esperado"];
}

$i = 0;

$a_evaluadas = array();
$cr_aprobados = array();
$nombres_crs = array();

foreach ($act_ids as $aid) {

	/* Se obtiene el total de estudiantes en la actividad. */
	$query = mysql_query("SELECT distinct mat_id FROM Evaluacion WHERE act_id='$aid';")
		or die(mysql_error());
	$estudiantes = mysql_num_rows($query);

	if ($estudiantes>0) {
		/* Se obtienen los ids y nombres de los criterios en la rubrica. */
		$query = mysql_query("SELECT crit_id, nombre_crit FROM RubricaLocal NATURAL 
		JOIN Actividades NATURAL JOIN Criterios WHERE act_id = '$aid';")
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
				$totales[$criterio][9] = 0;
				// Retiene el total de estudiantes con 6 o mas.	

				for ($escala=0; $escala<=8; $escala++) { // Escala - Columnas
			    	$query = mysql_query("Select count(ptos_obtenidos) from Evaluacion 
						where ptos_obtenidos=".$escala." && crit_id=".$cids[$criterio]." 
						&& act_id=".$aid.";") or die(mysql_error());
					if(mysql_num_rows($query) > 0) {
						$result = mysql_fetch_array($query);
						$totales[$criterio][$escala] = $result[0];
					} else  $totales[$criterio][$escala] = 0;
	
					// Se generan los totales de estudiantes que obtuvieron 6 o mas.
					if ($escala >= 6) {
						$totales[$criterio][9]+=$totales[$criterio][$escala];
					}
				}	
				// Se halla el porciento de estudiantes que aprobaron el criterio
				$totales[$criterio][9] = round((($totales[$criterio][9])/
					$estudiantes)*100,2);

				// Verificar si el criterio fue aprobado
				if ($totales[$criterio][9] >= $logrosesperados[$i]) {
					$totales[$criterio][10] = 'Aprobado'; 
				}
				else {
					$totales[$criterio][10] = 'No aprobado';
				}			
			}

			for($k=0; $k<$crit_qty; $k++){
				$a_evaluadas[] = $aid;
				$cr_aprobados[] = $totales[$k][10];
				$nombres_crs[] = $criterios[$k];
			}
		}
		$i++;
	}
}
/*
print_r($cr_aprobados);
print_r($nombres_crs);
*/
// DOMINIOS

$query = mysql_query("Select distinct nombre_dom, nombre_crit from Dominios natural join 
	Criterios natural join Evaluacion natural join CriterioPertenece natural join 
	ActividadesCurso where curso_id='$curso_id';") or die(mysql_error());

$dominios = array();	// Nombres de los dominios
$d_span = array();		/* Span de cada dominio (para efecto rowspan en tabla html) -
						   Almacena la cantidad de criterios asociados al dominio */
$criterios2 = array();	/* Nombres de los criterios (esta vez en el orden asociado 
						   a los dominios) */
$i = -1;	

while ($result = mysql_fetch_array($query)) {
	
	$criterios2[] = $result['nombre_crit'];

	// Si el dominio no esta ya en el arreglo, se guarda
	if (!in_array($result['nombre_dom'], $dominios)) { 
		$dominios[] = $result['nombre_dom'];
		$i++;	
		$d_span[$i] = 1;
	}
	else {
		$d_span[$i]++;
	}
}

$aprobados = array(); // Acumulador de criterios aprobados por dominio.
for ($i = 0; $i < sizeof($dominios); $i++) $aprobados[$i] = 0; // Inicializacion

$porciento = array(); // Almacena el porciento de criterios aprobados
$dom_alcanzado = array(); // Retiene si se alcanzo o no el dominio

$first = 0; // Donde se comienza a iterar 
$last = 0;  // Donde se termina de iterar
$iter = 0;  // Contador de iteraciones - Cada iteracion corresponde a un dominio

foreach ($d_span as $asociados) {
	$last += $asociados; /* Termina cuando se itere por todos los criterios
							asociados al dominio. */
	
	/* Se verifica cuantos de los criterios alineados a los dominios fueron aprobados. */
	for ($i = $first; $i < $last; $i++) {
		$filas = array_keys($nombres_crs, $criterios2[$i]);
		foreach ($filas as $fila) {
			if ($cr_aprobados[$fila] == 'Aprobado') {
				$aprobados[$iter]++; // Aumento el conteo de criterios aprobados
			}
		}
	}
	// Se computa el porciento de criterios aprobados
	$porciento[] = round(($aprobados[$iter]/$asociados)*100,2);

	// Se verifica si el dominio se alcanzo 
	if (round($porciento[$iter],-1) >= 70) {
		$dom_alcanzado[] = 'Aprobado';
	}
	else $dom_alcanzado[] = 'No aprobado';

	$first = $last; // Establezco desde donde comienza la nueva iteracion.
	$iter++; // Vamos al proximo dominio
}
/*
print_r($criterios2);
print_r($aprobados);
*/

$tabla2 ="<p> Actividades evaluadas: ".count($a_evaluadas)."
	<table id = ag_dominios border='1'>
	 <caption>Tabla de agregados por dominios</caption>
        <tr>
	       <th>Dominios</th>
	       <th>Criterios Alineados</th>
	       <th>Criterios Aprobados</th>
		   <th>Porcentaje</th>
		   <th>Aprobado o no aprobado</th>
	    </tr>";

$dom_i = 0;
$span = 0;

for ($i=0; $i<sizeof($criterios2); $i++) {
	if($i == $span) {
		$tabla2.="<tr><td rowspan=".$d_span[$dom_i].">".$dominios[$dom_i]."</td>";
	}
    $tabla2.="<td>".$criterios2[$i]."</td>";
	if($i == $span) {
		$tabla2.="<td rowspan=".$d_span[$dom_i].">".$aprobados[$dom_i]." de ".$d_span[$dom_i]." </td>";
		$tabla2.="<td rowspan=".$d_span[$dom_i].">".$porciento[$dom_i]."</td> 
		<td rowspan=".$d_span[$dom_i].">".$dom_alcanzado[$dom_i]."</td>" ;
		$span += $d_span[$dom_i];
		$dom_i++;
	}
	$tabla2.="</tr>";
}



echo $tabla2;
echo "</html>"

?>
