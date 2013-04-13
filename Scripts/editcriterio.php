<?php 

/*

Christian A. Rodriguez Encarnacion

Este es el script que se llama cuando el administrador desea editar un criterio.
Permite que el usuario selecciones el criterio a editar, para luego pasar a editcritform.php

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

$critquery = "SELECT crit_id, nombre_crit from Criterios";

$crits = mysql_query($critquery);

$output = "<div id='content'>
			<center>
			<h2>Edit Criterio</h2>
			<form>
			<h3>Seleccione un criterio</h3>
			<select name='crit' id='crit'>";
while ($row = mysql_fetch_array($crits)) {
	$output = $output."<option value='".$row['crit_id']."'>".$row['nombre_crit']."</option>";
}
$output = $output."</select><br>
			<input type='submit' value='Seleccionar Criterio' class='btn btn-primary'>
			</form>
			</center>
			</div>


			<script type='text/javascript'>

			$('form').submit(function() {
  				var data = $(this).serialize();

				var url = '../Scripts/editcritform.php?'+data;							
				console.log(url)
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})

				return false;
			});

			</script>";

echo $output;


 ?>