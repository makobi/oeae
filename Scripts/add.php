<?php 
/*
Christian A. Rodriguez Encarnacion
Este script se encarga de crear la actividad con los credenciales de
activity.php.

Updates:
	- Se modifico queries para DB version 2.
	- Se guarda copia de la rubrica en RubricaLocal.
*/

session_start();

$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
	mysql_select_db("Avaluo");
} else {
	echo "Could not connect to db";
	exit();
}

// Pull data from the POST
$nombre_act = $_GET['nombre_act'];
$rub_id = $_GET['rub_id'];
$logro_esperado = $_GET['logro_esperado'];

// Query to create an activity
$actividad = mysql_query("INSERT INTO Actividades (nombre_act, rublocal_id, logro_esperado) values
	('$nombre_act', '$rub_id','$logro_esperado')") or die(mysql_error());

// Query to fetch the act_id
$newactivity = mysql_query("SELECT act_id from Actividades where nombre_act='$nombre_act'")
	or die(mysql_error());
$res = mysql_fetch_array($newactivity);
$act_id = $res["act_id"];

//$_SESSION['act_id'] = $act_id;

// Query to relate the activity to a course
$curso = mysql_query("INSERT INTO ActividadesCurso (act_id, curso_id) values ('$act_id',
	'$_SESSION[curso_id]')") or die (mysql_error());

// Fetch the rubric from Rubricas and save it in RubricaLocal
$query1 = mysql_query("SELECT crit_id FROM Rubricas WHERE rub_id='$rub_id'")
	or die(mysql_error());

if (mysql_num_rows($query1) > 0) {
	$cids = array();
	while ($result = mysql_fetch_array($query1)) {
		$cids[] = $result['crit_id'];	
	}
}

$query2 = mysql_query("SELECT MAX(rublocal_id) AS ultima FROM RubricaLocal;") 
	or die (mysql_error());
	$result = mysql_fetch_array($query2);
	$newrid = $result["ultima"] + 1;

foreach ($cids as $cid) {
	$query3 = mysql_query("INSERT INTO RubricaLocal (rublocal_id, crit_id, prof_id) 
		VALUES ('$newrid','$cid','$_SESSION[prof_id]')") or die (mysql_error());
}
?>
