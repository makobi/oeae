<?php 

/*

Christian A. Rodriguez Encarnacion
Este Script desplega los parametros para la creación de un nuevo criterio.

NECESITO AYUDA DE TAHIRI PARA TERMINAR

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


$output = " <div id='content'>
 	<center>
 		<h2>Create Dominio</h2>
 		<form>
 			<h4>Nombre Dominio</h4>
 			<input type='text' name='nombre_dom'>";
 	$output = $output."	<br><br>
 	<input type='submit' value='Crear Dominio' class='btn btn-primary'>
 	</form>
 	</center>
 	<br>
 	<br>
 	<br>
 	<br>
 </div>	

			<script type='text/javascript'>

			$('form').submit(function() {
  				var data = $(this).serialize();

				var url = '../Scripts/adddom.php?'+data;							
				console.log(url)
				$.get(url, function(res) {
					alert(res);
					window.location.replace('./admin.php');
				})

				return false;
			});

			</script>

";	

echo $output;
?>