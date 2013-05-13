<?php 

/*

Christian A. Rodriguez Encarnacion

Este script se encarga de añadir el criterio nuevo a la base de datos

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

$nombre_dom = $_GET['nombre_dom'];


$insert = "INSERT into Dominios (nombre_dom, valor_esperado) values ('$nombre_dom', 70)";
mysql_query($insert);

echo "Se añadio el Dominio $nombre_dom!";

 ?>