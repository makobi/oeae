<?php 
/*
Christian A. Rodriguez Encarnacion
Este script se encarga de crear la actividad con los credenciales de
activity.php. Todavia falta ver si hace falta insertar informacion en otros
lugares que no sean la tabla Actividades.
*/

$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
	mysql_select_db("Avaluo");
} else {
	echo "Could not connect to db";
	exit();
}

// Pull data from the POST
$nombre_act = $_POST['nombre_act'];
$rub_id = $_POST['rub_id'];
$logro_esperado = $_POST['logro_esperado'];


// Insert query
$query = "INSERT INTO Actividades (nombre_act, rub_id, logro_esperado) values ('$nombre_act', '$rub_id', '$logro_esperado')";

if (mysql_query($query)) {
	echo "Se creo la actividad";
} else {
	echo "No se creo la actividad";
}



 ?>