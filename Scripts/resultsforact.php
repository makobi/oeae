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

$aid =1; $_SESSION['act_id'];

/* Se obtiene el logro esperado. */
$query = mysql_query("SELECT logro_esperado FROM Actividades where act_id='$aid';")
		or die(mysql_error());
$result = mysql_fetch_array($query);
$logroesperado = $result["logro_esperado"];

echo "Actividad: ".$aid."\n Logro esperado: ".$logroesperado."\n";

/* Se obtienen los ids y nombres de los criterios en la rubrica. */
$query = mysql_query("SELECT crit_id, nombre_crit FROM RubricaLocal NATURAL JOIN 
		Actividades NATURAL JOIN Criterios WHERE act_id = '$aid';") or die(mysql_error());

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

$totales = array(array());

/* Se obtienen los totales para cada escala en la rubrica. */
for($criterio=0; $criterio<$crit_qty; $criterio++) { // Criterios - Filas
	$totales[$criterio][9] = 0; // Retiene el total de estudiantes con 6 o mas.

	for ($escala=0; $escala<=8; $escala++) { // Escala - Columnas
    	$query = mysql_query("Select count(ptos_obtenidos) from Evaluacion where 
			ptos_obtenidos=".$escala." && crit_id=".$cids[$criterio]." 
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
	$totales[$criterio][9] = (($totales[$criterio][9])/$estudiantes)*100;
}

//print_r($totales);

echo "<div id='content'><center>
	<h1>Resultados para la actividad ".$aid."</h1>";

// Se comienza a generar la tabla de los totales
$tabla ="<table id = totales>
	 <caption>Tabla de distribución de puntuaciones</caption>
            <tr>
	       <th>Criterios</th>
	       <th colspan='9'>Escala</th>
	       <th>Porciento de estudiantes que aprobaron</th>
	    </tr>
	    <tr><td> </td>
		<td>0</td>
		<td>1</td>
		<td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
		<td>8</td>
		<td> </td> 
            </tr>";

// Se llena la tabla con los resultados
for ($i=0; $i<$crit_qty; $i++) {
    $tabla.="<tr><td><p>".$criterios[$i]."</p>";
    for($j=0; $j<=9; $j++) {
	$tabla.="</td>
                 <td>".$totales[$i][$j]."</td>";
    }
    $tabla.="</tr>";
}

$tabla.="</table>   
	 </center></div>";

echo $tabla;

?>
