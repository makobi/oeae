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

$crit = $_SESSION['crit'];

$updatecrit = "UPDATE Criterios set nombre_crit='$nombre_crit' where crit_id='$crit'";
mysql_query($updatecrit);

$delescala = "DELETE FROM EscalaCriterio where crit_id='$crit'";
mysql_query($delescala);

foreach ($coments as $value => $coment) {
		$escalaquery = "INSERT into EscalaCriterio (crit_id, valor, descripcion) values ($crit,$value,'$coment')";
		mysql_query($escalaquery);
	}

$deldom = "DELETE from CriterioPertenece where crit_id='$crit'";
mysql_query($deldom);

foreach ($dom as $dominio) {
		$domquery = "INSERT into CriterioPertenece (dom_id,crit_id) values ($dominio,$crit)";
		mysql_query($domquery);
	}

echo "Se edito el criterio $nombre_crit!";

 ?>