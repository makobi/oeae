<?php 
/***************************************************************************************************
Tahiri Laboy De Jesus
Archivo que trabaja los queries para ver una rubrica.

Recibe el id de la actividad.
Devuelve los criterios de la rubrica y la informacion para cada escala.
(La escala va del 1 a 8).
***************************************************************************************************/

$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

//if (isset($_POST['rub_id'])) {
	if ($link) {
		if(mysql_select_db($database)) {

		$rid = 1;//$_POST['rub_id'];

		// Busco el id de los criterios asociados a esa rubrica
		$query1 = mysql_query("SELECT crit_id FROM Rubricas WHERE rub_id = '$rid'")
					or die(mysql_error());

		// Verifica que hayan resultados
		if (mysql_num_rows($query1) > 0) {
			$cids = array();
			while ($result = mysql_fetch_array($query1)) {
				$cids[] = $result["crit_id"];
			} 
			
			//print_r($cids);		

			$criterios = array();
			foreach ($cids as $cid) {
				//Busco los nombres de los criterios
				$query2 = mysql_query("SELECT nombre_crit FROM Criterios WHERE crit_id = '$cid'")
					or die(mysql_error());
				$result = mysql_fetch_array($query2);
				$criterios[$cid] = $result["nombre_crit"];
			}
			
			$descripcion = array(array());
			$valor = array();

			foreach ($cids as $cid) {
				$query3 = mysql_query("SELECT descripcion, valor FROM EscalaCriterio WHERE crit_id = $cid ORDER BY valor;")
						or die(mysql_error());
				while ($result = mysql_fetch_array($query3)) {
					$valor = $result["valor"];
					$descripcion[$cid][$valor] = $result["descripcion"];
				}
			}
	
			// Print Array desc
			foreach ($descripcion as $critid => $descs) {
			    foreach ($descs as $desc) {
			        echo "Crit_id: {$critid}, desc: {$desc}\n";
    }
}
		}
	
		

		else echo "Rubric does not exist!";
		
		} // Termina el if select database

	} // Termina if link al servidor

//} // Termina el if rub_id isset

else { // Si no recibo el id de rubrica
	echo "Access Denied"; 
}
?>
