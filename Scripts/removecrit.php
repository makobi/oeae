<?php 
/*
	Script para editar (anadir/remover) criterios en la rubrica
	Revisado el 15 de marzo
*/


session_start();

// Connect to the Database
$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
  mysql_select_db("Avaluo");
} else {
  echo "Not able to connect to databases.";
  exit();
}
/***************************************************************************************************/
// Generar Rubrica
		$aid = $_SESSION['act_id'];

		// Busco el id de los criterios asociados a esa rubrica
//		$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN Rubricas WHERE act_id = '$aid'")
//					or die(mysql_error());

		
			$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN RubricaLocal WHERE act_id = '$aid'")
					or die(mysql_error());
		

		// Verifica que hayan resultados
		$crit_qty = mysql_num_rows($query1); 
		if ($crit_qty > 0) {
			$cids = array();
			while ($result = mysql_fetch_array($query1)) {
				$cids[] = $result["crit_id"];
			}
		}


$rubidquery = "SELECT rublocal_id from Actividades where act_id=$aid";
$rub = mysql_fetch_array(mysql_query($rubidquery));
$rub_id=$rub[0];

for ($i=0; $i < $crit_qty; $i++) { 
	if (isset($_GET[$cids[$i]])) {

		// Query para borrar los criterios seleccionados por el usuario
		$delquery = "DELETE FROM RubricaLocal WHERE rublocal_id=$rub_id AND crit_id=".$cids[$i]." AND prof_id=".$_SESSION['prof_id'];
		if(mysql_query($delquery)) {

		}
	}
	$index = 'crit'.$cids[$i];
	$descripciones = $_GET[$index];
	mysql_query("UPDATE EscalaCriterio set descripcion='$descripciones[0]' where crit_id=".$cids[$i]." and valor=2");
	mysql_query("UPDATE EscalaCriterio set descripcion='$descripciones[1]' where crit_id=".$cids[$i]." and valor=4");
	mysql_query("UPDATE EscalaCriterio set descripcion='$descripciones[2]' where crit_id=".$cids[$i]." and valor=6");
	mysql_query("UPDATE EscalaCriterio set descripcion='$descripciones[3]' where crit_id=".$cids[$i]." and valor=8");

}

if ($_GET['addcriterio']!=0) {
	// Query para insertar criterios a la Rubrica Local
	$addquery = "INSERT INTO RubricaLocal (rublocal_id,crit_id,prof_id) values (".$rub_id.",".$_GET['addcriterio'].",".$_SESSION['prof_id'].")";
	if (mysql_query($addquery)) {
	}
}

echo "Criterion Removed!";

 ?>
