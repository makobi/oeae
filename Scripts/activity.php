<!-- 
Christian A. Rodriguez Encarnacion
Este es el script preliminar para crear una actividad en un curso.
Despues de someter los credenciales de la actividad, vamos a
add.php donde se crea verdaderamente la actividad.
 -->

<html>
<head>
	<title>Add Activity</title>
	<?php 

	 $db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

	// Choose the database 'Avaluo'
	if ($db) {
		mysql_select_db("Avaluo");
	} else {
		echo "Could not connect to db";
		exit();
	}


	// Select the distinct Rubrics from the database
	$query = mysql_query("SELECT distinct rub_id FROM Rubricas");


	 ?>
</head>
<body>
	<form method='post' action='add.php'>
		Nombre de la Actividad: <br>
		<input type='text' name='nombre_act'> <br>
		Seleccione Rubrica para la actividad <br>
		<select name='rub_id'>
		<?php 
		// Show different rubrics for the professor to choose
		while ($row = mysql_fetch_array($query)) {
			echo "<option>".strval($row[0])."</option><br>";
			echo "algo";
		} 
		mysql_free_result($query);

		?>
		</select> <br>
		Logro Esperado (1-100) <br>
		<input type='text' name='logro_esperado'> <br>
		<input type='Submit' value='Crear Actividad'>
	</form>
</body>
</html>