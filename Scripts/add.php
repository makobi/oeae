<?php 
/*
Christian A. Rodriguez Encarnacion
Este script se encarga de crear la actividad con los credenciales de
activity.php. Todavia falta ver si hace falta insertar informacion en otros
lugares que no sean la tabla Actividades.
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


// Insert query
$actividad = "INSERT INTO Actividades (nombre_act, rub_id, logro_esperado) values ('$nombre_act', '$rub_id', '$logro_esperado')";

mysql_query($actividad);

$newactivity = mysql_query("SELECT act_id from Actividades where nombre_act='$nombre_act'");

$act_id = mysql_fetch_array($newactivity);

$curso = "INSERT INTO ActividadesCurso (act_id, curso_id) values (".intval($act_id[0]).",'$_SESSION[curso_id]')";

mysql_query($curso);

 ?>