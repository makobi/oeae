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
 			<h4>Nombre Criterio</h4>
 			<input type='text' name='nombre_crit'>
 			<h4>Comentario 1-2</h4>
 			<textarea rows='2' name='comentario2'></textarea>
 			<h4>Comentario 3-4</h4>
 			<textarea rows='2' name='comentario4'></textarea>
 			<h4>Comentario 5-6</h4>
 			<textarea rows='2' name='comentario6'></textarea>
 			<h4>Comentario 7-8</h4>
 			<textarea rows='2' name='comentario8'></textarea>
 			<h4>Dominios que pertenece</h4>";
 			 
 			while ($row = mysql_fetch_array($domres)) {
 				$output = $output."<label class='checkbox inline'>
				<input type='checkbox' name='dom[]' value=".$row[0].">".$row[1]."
				</label>";
 			}
 	$output = $output."	<br><br>
 	<input type='submit' value='Crear Criterio' class='btn btn-primary'>
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