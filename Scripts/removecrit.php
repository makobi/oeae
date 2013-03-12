<?php 

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

echo "<div id='content'>
		<center>";
/***************************************************************************************************/
// Generar Rubrica
		$aid = $_SESSION['act_id'];

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

$rubidquery = "SELECT rub_id from Actividades where act_id=$aid";
$rub = mysql_fetch_array(mysql_query($rubidquery));
$rub_id=$rub[0];


for ($i=0; $i < $crit_qty; $i++) { 
	if (isset($_GET[$cids[$i]])) {
		$delquery = "DELETE FROM Rubricas WHERE rub_id=$rub_id AND crit_id=".$cids[$i];
		if(mysql_query($delquery)) {
			echo $cids[$i];
		}
	}
}

if ($_GET['addcriterio']!=0) {
	$addquery = "INSERT INTO Rubricas (rub_id,crit_id) values (".$rub_id.",".$_GET['addcriterio'].")";
	if (mysql_query($addquery)) {
		echo "<br>Criterio añadido!<br>";
	}
}


echo "	</center>
		</div>";

 ?>