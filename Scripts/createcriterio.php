<?php 

/*

Christian A. Rodriguez Encarnacion
Este Script desplega los parametros para la creación de un nuevo criterio.

NECESITO AYUDA DE TAHIRI PARA TERMINAR

*/

//session_start();

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
 			Nombre Criterio <br>
 			<input type='text'> <br>
 			Comentario 1-2 <br>
 			<textarea rows='2'></textarea> <br>
 			Comentario 3-4 <br>
 			<textarea rows='2'></textarea> <br>
 			Comentario 5-6 <br>
 			<textarea rows='2'></textarea> <br>
 			Comentario 7-8 <br>
 			<textarea rows='2'></textarea> <br>
 			Dominios que pertenece <br>";
 			 
 			while ($row = mysql_fetch_array($domres)) {
 				$output = $output."<label class='checkbox inline'>
				<input type='checkbox' name='dom' value=".$row[0].">".$row[1]."
				</label>";
 			}
 	$output = $output."	<br><br>
 	<input type='submit' value='Crear Criterio'</form>
 	</center>
 </div>


 ";

echo $output;

  ?>