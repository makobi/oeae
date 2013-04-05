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

$domquery = "SELECT dom_id, nombre_dom from Dominios";
$domres = mysql_query($domquery);	


$output = " <div id='content'>
 	<center>
 		<h2>Create Criterio</h2>
 		<form>
 			<h3>Nombre Criterio</h3> <br>
 			<input type='text' name='nombre_crit'> <br>
 			<h3>Comentario 1-2</h3> <br>
 			<textarea rows='2' name='comentario2'></textarea> <br>
 			<h3>Comentario 3-4</h3> <br>
 			<textarea rows='2' name='comentario4'></textarea> <br>
 			<h3>Comentario 5-6</h3> <br>
 			<textarea rows='2' name='comentario6'></textarea> <br>
 			<h3>Comentario 7-8</h3> <br>
 			<textarea rows='2' name='comentario8'></textarea> <br>
 			<h3>Dominios que pertenece</h3> <br>";
 			 
 			while ($row = mysql_fetch_array($domres)) {
 				$output = $output."<label class='checkbox inline'>
				<input type='checkbox' name='dom[]' value=".$row[0].">".$row[1]."
				</label>";
 			}
 	$output = $output."	<br><br>
 	<input type='submit' value='Crear Criterio'>
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

				var url = '../Scripts/addcrit.php?'+data;							
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