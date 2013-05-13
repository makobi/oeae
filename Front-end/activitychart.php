<?php 

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
			$totales[$criterio][9] = '0';
			$totales[$criterio][10] = 'No evaluado';
		}
		else if ($totales[$criterio][9] >= $logroesperado) {
			$totales[$criterio][10] = 'Alcanzado';
		}
		else $totales[$criterio][10] = 'No alcanzado';
	} 
}




  // Obtengo los nombres de los diferentes dominios
  $query = mysql_query("select nombre_dom, nombre_crit from RubricaLocal natural join
	Dominios natural join CriterioPertenece natural join Criterios natural join Actividades
	where act_id='$aid';") or die(mysql_error());

  $d = array();
  $dominios = array();	// Nombres de los dominios
  $d_span = array();		/* Span de cada dominio (para efecto rowspan en tabla html) -
						   Almacena la cantidad de criterios asociados al dominio */
  $criterios_alineados = array();	/* Nombres de los criterios (esta vez en el orden asociado 
						   a los dominios) */
	
  while ($result = mysql_fetch_array($query)) {
	$d[] = $result['nombre_dom']; // En algun momento se me ocurrira una manera mas elegante de resolver esto
	if (!in_array($result['nombre_dom'], $dominios)) { 
		$dominios[] = $result['nombre_dom'];
	}
	$criterios_alineados[] = $result['nombre_crit'];
  }

  $d_span = array_count_values($d); // Relaciona el dominio con su span

  $aprobados = array(); // Acumulador de criterios aprobados por dominio
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
			$criterios_alineados[$i] .= "*";
			$mensaje = "<br><p>*Criterio no evaluado.";
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


 ?>

 <html>
 <head>
 	<title>Activity Chart</title>
 	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
 	 <script type='text/javascript'>
  	  google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart);

      function drawChart() {

		var distr = new google.visualization.DataTable();

        distr.addColumn('string', 'Criterio');
        distr.addColumn('number', '0 pts');
        distr.addColumn('number', '1 pts');
        distr.addColumn('number', '2 pts');
        distr.addColumn('number', '3 pts');
        distr.addColumn('number', '4 pts');
        distr.addColumn('number', '5 pts');
        distr.addColumn('number', '6 pts');
        distr.addColumn('number', '7 pts');
        distr.addColumn('number', '8 pts');

        <?php  
		for ($i=0; $i < $crit_qty; $i++) { 
		echo 'distr.addRow(["'.$criterios[$i].'",  
            '.$totales[$i][0].',   
            '.$totales[$i][1].',
            '.$totales[$i][2].',
            '.$totales[$i][3].',
            '.$totales[$i][4].',
            '.$totales[$i][5].',
            '.$totales[$i][6].',
            '.$totales[$i][7].',
            '.$totales[$i][8].'
          ]);';
		}
		?>

        var options = {
          title: 'Distribucion de Valores por Criterio',
          hAxis: {title: 'Criterios',  titleTextStyle: {color: 'black'}},
          vAxis: {title: 'Cantidad de Estudiantes',titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('column_div'));
        chart.draw(distr, options);


		var agrupados = new google.visualization.DataTable();

        agrupados.addColumn('string', 'Criterio');
        agrupados.addColumn('number', 'Logro Esperado');
        agrupados.addColumn('number', 'Menor al Logro Esperado');
		
		<?php  
		for ($i=1; $i <= $crit_qty; $i++) { 
		echo 'agrupados.addRow(["'.$criterios[$i-1].'",  '.(0.01*$totales[$i-1][9]).',   '.strval((100-$totales[$i-1][9])*0.01).' ]);';
		}
		?>
		
		var options2 = {
			<?php echo "title: 'Resultados agrupados para la actividad: ".$name."',"; ?>
          
          hAxis: {title: 'Criterios',  titleTextStyle: {color: 'black'}},
          vAxis: {title: 'Porcentaje de Estudiantes', format:'#%',titleTextStyle: {color: 'black'}}
        };

        var chart2 = new google.visualization.ColumnChart(document.getElementById('column2_div'));
        chart2.draw(agrupados, options2);

        var dominios = new google.visualization.DataTable();

        dominios.addColumn('string', 'Dominio');
        dominios.addColumn('number', 'Logro Esperado');
        dominios.addColumn('number', 'Menor al Logro Esperado');

        <?php 
        for ($i=0; $i < count($dominios); $i++) { 
        	echo 'dominios.addRow(["'.$dominios[$i].'",'.($porciento[$i]*0.01).','.strval((100-$porciento[$i])*0.01).']);';
        }

         ?>

		var options3 = {
			<?php echo "title: 'Resultados de dominios para la actividad: ".$name."',"; ?>
          
          hAxis: {title: 'Dominio',  titleTextStyle: {color: 'black'}},
          vAxis: {title: 'Porcentaje de Criterios', format:'#%',titleTextStyle: {color: 'black'}}
        };

        var chart3 = new google.visualization.ColumnChart(document.getElementById('column3_div'));
        chart3.draw(dominios, options3);

    	}
</script>

 </head>
 <body>
 	<div id='column_div' style='width: 700px; height: 500px;'></div>
 	<div id='column2_div' style='width: 700px; height: 500px;'></div>
 	<div id='column3_div' style='width: 700px; height: 500px;'></div>
 </body>
 </html>