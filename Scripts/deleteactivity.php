<?php 

$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

session_start();

if ($link) {
	mysql_select_db("Avaluo");
} else {
	echo "Access Denied!";
	exit();
}

$act = $_SESSION['act_id'];

$query = "DELETE from Actividades where act_id=".$act;

if (mysql_query($query)) {
	echo "Deleted activity ".$_SESSION['nombre_act'];
} else {
	echo "Could not delete activity ".$_SESSION['nombre_act'];
}

 ?>