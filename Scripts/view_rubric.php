<?php 
/***************************************************************************************************
Tahiri Laboy De Jesus
Archivo que trabaja los queries para ver una rubrica.

Recibe el id de la rubrica.
Devuelve los criterios de la rubrica y la informacion para cada escala.
(La escala va del 1 a 8).
***************************************************************************************************/

$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

if (isset($_GET['rub_id'])) {
	if ($link) {
		if(mysql_select_db($database)) {

		$rid = $_GET['rub_id'];
		$type= $_GET['type'];

		// Si la rubrica es global
		if ($type == '0') {
			// Busco el id de los criterios asociados a esa rubrica
			$query1 = mysql_query("SELECT crit_id FROM Rubricas WHERE rub_id = '$rid'")
					or die(mysql_error());

			// Nombre de la rubrica
			$query = mysql_query("SELECT nombre_rub FROM NombresRubricas WHERE rub_id = '$rid';")
					or die(mysql_error());
			$nombre = mysql_fetch_array($query);
		// Si la rubrica es local
		} else {
			// Busco el id de los criterios asociados a esa rubrica local
			$query1 = mysql_query("SELECT crit_id FROM RubricaLocal WHERE rublocal_id = '$rid'")
					or die(mysql_error());

			// Nombre de la rubrica local
			$query = mysql_query("SELECT nombre_rub FROM NombresRubricasLocal WHERE rublocal_id = '$rid';")
					or die(mysql_error());
			$nombre = mysql_fetch_array($query);
		}
		

		$crit_qty = mysql_num_rows($query1);
		// Verifica que hayan resultados
		if ($crit_qty > 0) {
			$cids = array();
			while ($result = mysql_fetch_array($query1)) {
				$cids[] = $result["crit_id"];
			} 		

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

			// Se generan las descripciones para cada escala del criterio
			foreach ($cids as $cid) {
				$query3 = mysql_query("SELECT descripcion, valor FROM EscalaCriterio
						WHERE crit_id = $cid ORDER BY valor;")
						or die(mysql_error());
				while ($result = mysql_fetch_array($query3)) {
					$valor = $result["valor"];
					$descripcion[$cid][$valor] = $result["descripcion"];
				}
			}

// Funciones en JS
/* ReturnToRubricsDB - Permite volver al banco de Rubricas */
echo "<script type='text/javascript'>
		function ReturnToRubricsDB() {
			url = '../Scripts/rubricdatabase.php';
			$.get(url, function(html) {
				$('#content').hide()
				$('#content').replaceWith(html)
			})
		}
	  </script>";

// Aqui se comienza a generar la tabla de la rubrica
$table="<div id='content'><center>
<a href='#' onClick='ReturnToRubricsDB()'>Return to Rubric Database</a>
			<h1>".$nombre['nombre_rub']."</h1>
			<table id='rubrica'><tr>
				<td>  </td>
				<td>1-2</td>
				<td>3-4</td>
				<td>5-6</td>
				<td>7-8</td>
				</tr>";


// Cada fila de la rubrica representa un criterio
for ($i=0; $i < $crit_qty; $i++) {
		$table=$table."<tr>
				<td><p>".$criterios[$cids[$i]]."</p></td>
				<td>".$descripcion[$cids[$i]][2]."</td>
				<td>".$descripcion[$cids[$i]][4]."</td>
				<td>".$descripcion[$cids[$i]][6]."</td>
				<td>".$descripcion[$cids[$i]][8]."</td>
				</tr>";
}

$table.="</table>
			<br>
		</center></div>";

echo $table;
}
	
		else echo "<div id='content'><center>
					Rubric does not exist!
					</center></div>";
		
		} // Termina el if select database

	} // Termina if link al servidor

} // Termina el if rub_id isset

else { // Si no recibo el id de rubrica
	echo "Access Denied!"; 
}
?>
