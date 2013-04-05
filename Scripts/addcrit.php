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

$nombre_crit = $_GET['nombre_crit'];
$coments = array();
$coments['2'] = $_GET['comentario2'];
$coments['4'] = $_GET['comentario4'];
$coments['6'] = $_GET['comentario6'];
$coments['8'] = $_GET['comentario8'];
$dom = $_GET['dom'];


$insertcrit = "INSERT into Criterios (nombre_crit) values ('$nombre_crit')";
mysql_query($insertcrit);

	$idquery = "SELECT crit_id from Criterios where nombre_crit='$nombre_crit'";
	$id = mysql_query($idquery);
	$cid = mysql_fetch_array($id);
	$cid = $cid[0];
	foreach ($coments as $value => $coment) {
		$escalaquery = "INSERT into EscalaCriterio (crit_id, valor, descripcion) values ($cid,$value,'$coment')";
		mysql_query($escalaquery);
	}
	foreach ($dom as $dominio) {
		$domquery = "INSERT into CriterioPertenece (dom_id,crit_id) values ($dominio,$cid)";
		mysql_query($domquery);
	}

echo "Se añadio el criterio $nombre_crit!";

 ?>