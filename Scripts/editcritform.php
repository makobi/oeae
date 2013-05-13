<?php 

session_start();

$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");
// Choose the database 'Avaluo'
if ($db) {
	mysql_select_db("Avaluo");
} else {
	echo "Could not connect to db";
	exit();
}

$_SESSION['crit'] = $_GET['crit'];

$crit = $_SESSION['crit'];

$nombrequery = "SELECT nombre_crit from Criterios where crit_id=$crit";

$nombre = mysql_query($nombrequery);

$nombre_crit = mysql_fetch_array($nombre);

$evalquery = "SELECT valor, descripcion from EscalaCriterio where crit_id=$crit order by valor";

$eval = mysql_query($evalquery);

$domquery = "SELECT dom_id, nombre_dom from Dominios";
$domres = mysql_query($domquery);

$dompertenece = "SELECT dom_id from CriterioPertenece where crit_id=$crit";

$output = " <div id='content'>
 	<center>
 		<h2>Create Criterion</h2>
 		<form>
 			<h4>Criterion's Name</h4> 
 			<input type='text' name='nombre_crit' value='".$nombre_crit[0]."'> ";

 			while ($res = mysql_fetch_array($eval)) {
 				$output = $output."
 				<h4>Level of execution ".strval(intval($res['valor'])-1)."-".$res['valor']."</h4> 
 			<textarea rows='4' name='comentario".$res['valor']."'>".$res['descripcion']."</textarea> ";
 			}
 			$output = $output."<h4>Domain to which it belongs:</h4> ";
 			 
 			while ($row = mysql_fetch_array($domres)) {
 				$check = false;
 				$domcrit = mysql_query($dompertenece);
 				while ($row2 = mysql_fetch_array($domcrit)) {
 					if ($row[0] == $row2[0]) {
 						$check = true;
 					}
 				}
 				if ($check) {
 					$output = $output."<label class='checkbox inline'>
					<input type='checkbox' name='dom[]' checked='checked' value=".$row[0].">".$row[1]."
					</label>";
 				} else {
 					 $output = $output."<label class='checkbox inline'>
					<input type='checkbox' name='dom[]' value=".$row[0].">".$row[1]."
					</label>";
 				}
 			}
 	$output = $output."	<br> <br>
 	<input type='submit' value='Submit Edit' class='btn btn-danger'>
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

				var url = '../Scripts/editarcriterio.php?'+data;							
				console.log(url)
				$.get(url, function(res) {
					alert(res);
					window.location.replace('./admin.php');
				})

				return false;
			});

			</script>";

 echo $output;


 ?>