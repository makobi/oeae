<?php 

/*
Christian A. Rodriguez Encarnacion

Este script guarda la puntuacion de un estudiante en una actividad.
Por ahora estamos suponiendo que el profesor no va a dejar ningun
field vacio.

*/

session_start();

// Connect to the Database
$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
  mysql_select_db("Avaluo");
} else {
  echo "no salio";
  exit();
}

// Id de la actividad
$aid = $_SESSION['act_id'];

// Id del estudiante
$est_id = $_GET['est_id'];


// Id del curso
$curso = $_SESSION['course_id'];

// Id del estudiante matriculado en el curso
$matquery = mysql_query("SELECT mat_id from Matricula where curso_id=$curso and est_id=$est_id");
$mat = mysql_fetch_array($matquery);
$mat_id = $mat[0];

// Busco el id de los criterios asociados a esa rubrica
$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN Rubricas WHERE act_id = '$aid'")
			or die(mysql_error());

// Verifica que hayan resultados
$crit_qty = mysql_num_rows($query1); 
if ($crit_qty > 0) {
	$cids = array();
	while ($result = mysql_fetch_array($query1)) {
		$cids[] = $result["crit_id"];
	}
}

// Query para buscar Id de la rubrica
$query2 = mysql_query("SELECT rub_id FROM Actividades where act_id='$aid'");
$rubrica = mysql_fetch_array($query2);
$rub_id = $rubrica[0];

// Por cada criterio haz un insert de los puntos obtenidos, y si es duplicado, haz un update
// (el contador es para mi)
$count = 0;
for ($i=0; $i < $crit_qty; $i++) { 
	$eval = "INSERT INTO Evaluacion 
			(act_id,crit_id,ptos_obtenidos,mat_id,rub_id)
			values 
			('$aid',".$cids[$i].",".$_GET[$cids[$i]].",$mat_id,$rub_id)
			ON DUPLICATE KEY UPDATE ptos_obtenidos=".$_GET[$cids[$i]];
	if (mysql_query($eval)) {
		$count++;
	}
}

// Si llegamos hasta aqui desplegar que se guardaron los resultados
echo "Evaluation has been saved.";

 ?>