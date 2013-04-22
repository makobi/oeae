<?php
/*
	Tahiri Laboy De Jesus
	Script para ver agregados por actividad
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


$name = $_SESSION['nombre_act'];
$id = $_SESSION['act_id'];

$rubrics = '../Scripts/viewcourse.php?nombre_act='.$name.'&act_id='.$id;



$aid = $_SESSION['act_id'];
$nombre = $_SESSION['nombre_act'];



/* Se obtiene el logro esperado. */
$query = mysql_query("SELECT logro_esperado FROM Actividades where act_id='$aid';")
		or die(mysql_error());
$result = mysql_fetch_array($query);
$logroesperado = $result["logro_esperado"];

/* Se obtienen los ids y nombres de los criterios en la rubrica. */
$query = mysql_query("SELECT crit_id, nombre_crit FROM RubricaLocal NATURAL JOIN Actividades NATURAL JOIN Criterios WHERE act_id = '$aid';") or die(mysql_error());

$crit_qty = mysql_num_rows($query);

// Verifica que hayan resultados
if ($crit_qty > 0) {
	$cids = array();
	$criterios = array();
	while ($result = mysql_fetch_array($query)) {
		$cids[] = $result["crit_id"];
		$criterios[] = $result["nombre_crit"];
	}
}
/* Se obtiene el total de estudiantes en la actividad. */
$query = mysql_query("SELECT distinct mat_id FROM Evaluacion WHERE act_id='$aid';")
	or die(mysql_error());
$estudiantes = mysql_num_rows($query);

if ($estudiantes > 0) {
	$totales = array(array());

	/* Se obtienen los totales para cada escala en la rubrica. */
	for($criterio=0; $criterio<$crit_qty; $criterio++) { // Criterios - Filas
		$totales[$criterio][9] = 0; // Retiene el total de estudiantes con 6 o mas.
		$totales[$criterio][11] = 0; // Para verificar si se han hecho evaluaciones o no.

		for ($escala=0; $escala<=8; $escala++) { // Escala - Columnas
    		$query = mysql_query("Select count(ptos_obtenidos) from Evaluacion where 
				ptos_obtenidos=".$escala." && crit_id=".$cids[$criterio]." 
				&& act_id=".$aid.";") or die(mysql_error());
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
		else if ($totales[$criterio][9] >= $logroesperado) {
			$totales[$criterio][10] = 'Alcanzado';
		}
		else $totales[$criterio][10] = 'No alcanzado';
	} 
}

//print_r($totales);

echo "<script type='text/javascript'>
			$('#students a').on('click', function() {
				var course = $(this).attr('id');
				var url = '../Scripts/students.php?course_id='+course;
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})
			});
	</script>

	<div id='content'><center>";
echo '					<table id="thumb0">
						<tr>
							<td>
					<ul class="thumbnails">
					  <li id="rubrics">
					    <a href="#" class="actividades" id="thumbnail" >
					    	<h3>Rubrics</h3>
					     </a>
					  </li>
					   <li id="thumb2">
					    <a href="#" class="thumbnail" id="thumbnail">
					    	<h3>Results</h3>
					     </a>
					  </li>

					  <li id="students">
					  	<div id="thumbnail">
					    	<a href="#" class="thumbnail" id="'.$_SESSION['course_id'].'" >
					    		<h3>Students</h3>
					     	</a>
					     </div>
					  </li>
					  
					</ul>
				</td>
				</tr>
				</table>';
echo "
	<h3>Resultados para ".$nombre."</h3>";
echo "  <p> Logro esperado: ".$logroesperado."\n";

$tabla = "";

/* Si se han evaluado estudiantes, desplegamos la tabla */
if ($estudiantes != 0) {
  // Se comienza a generar la tabla de los totales
  $tabla.="<table id = grading>
	 <caption><h4>Tabla de distribución de puntuaciones por criterio</h4></br>
	</caption>
	       <thead><td><p>Criterios</p></td>
	       <td colspan='9'><p>Escala</p></td>
	       <td><p>Porciento de estudiantes que aprobaron</p></td>
		   <td><p>Alcanzado o no alcanzado</p></td></thead>
	    <tbody><tr><td> </td>
				<td><b>0</b></td>
				<td><b>1</b></td>
				<td><b>2</b></td>
                <td><b>3</b></td>
                <td><b>4</b></td>
                <td><b>5</b></td>
                <td><b>6</b></td>
                <td><b>7</b></td>
				<td><b>8</b></td>
				<td> </td> 
            </tr>";

  // Se llena la tabla con los resultados
  for ($i=0; $i<$crit_qty; $i++) {
    $tabla.="<tr><td><p>".$criterios[$i]."</p>";
    for($j=0; $j<=10; $j++) {
	$tabla.="</td>
                 <td><p>".$totales[$i][$j]."</p></td>";
    }
    $tabla.="</tr>";
  }

  $tabla.="</tbody></table></br></br>";

/***************************** AGREGADOS POR DOMINIOS *****************************/

  // Obtengo los nombres de los diferentes dominios
  $query = mysql_query("select nombre_dom, nombre_crit from RubricaLocal natural join
	Dominios natural join CriterioPertenece natural join Criterios natural join Actividades
	where act_id='$aid';") or die(mysql_error());

  $dominios = array();	// Nombres de los dominios
  $d_span = array();		/* Span de cada dominio (para efecto rowspan en tabla html) -
						   Almacena la cantidad de criterios asociados al dominio */
  $criterios_alineados = array();	/* Nombres de los criterios (esta vez en el orden asociado 
						   a los dominios) */


//$i = -1;	

  while ($result = mysql_fetch_array($query)) {
	$dominios[] = $result['nombre_dom'];
	$criterios_alineados[] = $result['nombre_crit'];
	//$ptos_obtenidos[] = $result['ptos_obtenidos'];
  }

  $d_span = array_count_values($dominios);
  $dominios = array_unique($dominios);		// Remuevo repeticiones

  $aprobados = array(); // Acumulador de criterios aprobados por dominio.
  $noevaluados = array(); // Acumulador de criterios no evaluados

  for ($i = 0; $i < sizeof($dominios); $i++) {
	$aprobados[$i] = 0; // Inicializacion
	$noevaluados[$i] = 0;
  }

  $porciento = array(); // Almacena el porciento de criterios aprobados
  $dom_alcanzado = array(); // Retiene si se alcanzo o no el dominio

  $first = 0; // Donde se comienza a iterar 
  $last = 0;  // Donde se termina de iterar
  $iter = 0;  // Contador de iteraciones - Cada iteracion corresponde a un dominio


  foreach ($d_span as $asociados) {
	$last += $asociados; /* Termina cuando se itere por todos los criterios
							asociados al dominio. */
	
	// Se verifica cuantos de los criterios alineados a los dominios fueron aprobados. 
	for ($i = $first; $i < $last; $i++) {
		$fila = array_search($criterios_alineados[$i], $criterios);
		if ($totales[$fila][10] == 'Alcanzado') {
			$aprobados[$iter]++; // Aumento el conteo de criterios aprobados
		}
		else if ($totales[$fila][10] == 'No evaluado') {
			$noevaluados[$iter]++; // Aumento el conteo de criterios no evaluados
		}
	}
	// Se computa el porciento de criterios aprobados
	if ($asociados-$noevaluados[$iter] != 0) {
		$porciento[] = round(($aprobados[$iter]/($asociados-$noevaluados[$iter]))*100,2);
	
		// Se verifica si el dominio se alcanzo
		if (round($porciento[$iter],-1) >= 70) {
			$dom_alcanzado[] = 'Alcanzado';
		}
		else $dom_alcanzado[] = 'No alcanzado';
	}
	// Si ninguno de los criterios fue evaluado
	else {
		$porciento[] = "x";
		$dom_alcanzado[] = "No evaluado";
	}	

	$first = $last; // Establezco desde donde comienza la nueva iteracion.
	$iter++; // Vamos al proximo dominio
  }


/*
$tabla.="<table id = grading>
	 <caption><h4>Tabla de agregados por dominios</h4></br></caption>
        <thead>
	       <td><p>Dominios</p></td>
	       <td><p>Criterios Alineados</p></td>
	       <td><p>Criterios Aprobados</p></td>
		   <td><p>Porcentaje</p></td>
		   <td><p>Aprobado o no aprobado</p></td>
	    </thead><tbody>";

$dom_i = 0;
$span = 0;

for ($i=0; $i<sizeof($criterios2); $i++) {
	if($i == $span) {
		$tabla.="<tr><td rowspan=".$d_span[$dom_i].">".$dominios[$dom_i]."</td>";
	}
    $tabla.="<td>".$criterios2[$i]."</td>";
	if($i == $span) {
		$tabla.="<td rowspan=".$d_span[$dom_i].">".$aprobados[$dom_i]." de ".$d_span[$dom_i]." </td>";
		$tabla.="<td rowspan=".$d_span[$dom_i].">".$porciento[$dom_i]."</td> 
		<td rowspan=".$d_span[$dom_i].">".$dom_alcanzado[$dom_i]."</td>" ;
		$span += $d_span[$dom_i];
		$dom_i++;
	}
	$tabla.="</tr>";
}
$tabla.="</tbody></table>";
*/ 
}
else { // No se han evaluado estudiantes
  $tabla.="<p> Error: Aún no se han realizado evaluaciones para esta actividad.";
}   
  $tabla.="<br><br><br><br><br><br></center></div>

  			<script type='text/javascript'>

			$('#students a').on('click', function() {
				var course = $(this).attr('id');
				var url = '../Scripts/students.php?course_id='+course;
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})

			});

			$('#results a').on('click', function() {
				var url = '../Scripts/resultsforact.php';
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})
			});

			$('#rubrics a').on('click', function() {
				var url = '".$rubrics."';
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})
			});

</script>";

echo $tabla;

?>
