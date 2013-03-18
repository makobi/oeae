<?php
/*
	Tahiri Laboy De Jesus
	Script para crear rubrica (Administrativo)

	Revisado el 14 de marzo - Se necesita implementar para profesores. 
*/

$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

session_start();

if ($link) {
	mysql_select_db("Avaluo");
} else {
	echo "Access Denied!";
	exit();
}

$idscriterios = array();
$criterios = array();

// Se generan todos los nombres de los criterios
$query = mysql_query("SELECT crit_id, nombre_crit FROM Criterios ORDER BY nombre_crit;")
	or die(mysql_error());

while($result = mysql_fetch_array($query)) {
	$criterios[] = $result["nombre_crit"];
	$idscriterios[] = $result["crit_id"];
}

// Funcion para validar que el form no se someta en blanco
echo "<script type='text/javascript'>
			function validateCheckBoxes() {
		        var isValid = false; 
        		var allRows = document.getElementsByTagName('input');
        		for (var i=0; i < allRows.length; i++) {
        		    if (allRows[i].type == 'checkbox' && allRows[i].name == 'cr') {
        		        if (allRows[i].checked == true) {
        		               return true;
        		        }
        		    }
        		}
        		return isValid;
    		}

			function checkform() {
				if (document.nueva_rub.rname.value == '') {
					alert('Rubric name is required. Please try again.');
					return false;
				}
				else if (!validateCheckBoxes()) {
					alert('You need to select at least one option. Please try again.');
					return false;
				}
				else {
					alert('Rubric created succesfully!');				
					return true;
				}
			}
		</script>";

// Primera vez que se entra al script
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$me = $_SERVER['PHP_SELF'];

	echo "
		<div id = 'content'>
		<center>
			<form name='nueva_rub' action='".$me."' method='POST' 
			onSubmit = 'checkform()' class='form-inline'>
			<div><br>
			Rubric Name: <input type = 'text' name = 'rname'><br><br>";

	for ($i = 0; $i < mysql_num_rows($query); $i++) {
		echo "<label class='checkbox inline'>
			<input type='checkbox' name='cr' value=".$idscriterios[$i].">".$criterios[$i]."
			</label>";
	}
	echo"<br><br>
		<button type='submit' value='create'>Create!
			<br></div>
			</form>
			</center>
		</div>
		";

}
// Una vez se ha sometido la peticion
else {
  // Si tenemos los parametros necesarios, procedemos a crear.
  if (!empty($_POST['rname']) && !empty($_POST['cr'])) {
	$crits = array();

	$rname = array_shift($_POST);

	foreach($_POST as $critid) {
		$crits[] = $critid;
	}

	// Busco el id de la ultima rubrica en la base de datos
	$query = mysql_query("SELECT MAX(rub_id) AS ultima FROM Rubricas;") 
	or die (mysql_error());
	$result = mysql_fetch_array($query);
	$newrid = $result["ultima"] + 1;

	// Guardo la nueva rubrica
	foreach ($crits as $cid) {
		$query = mysql_query("INSERT INTO Rubricas(rub_id,crit_id) VALUES
			('$newrid','$cid');") 
			or die (mysql_error());
	}

	// Guardo nombre de la rubrica
	$query = mysql_query("INSERT INTO NombresRubricas(rub_id, nombre_rub)
		VALUES('$newrid','$rname');") or die (mysql_error());

	header( 'Location: ../Front-end/admin.php' ) ;
	
  }
  // Si no los tenemos, volvemos a mostrar el form.
  else {
		$me = $_SERVER['PHP_SELF'];
	
		echo "
			<div id = 'content'>
	
				<form name='nueva_rub' action='".$me."' method='POST' 
				onSubmit = 'checkform()'>
				<div><br>
				Rubric Name: <input type = 'text' name = 'rname'><br>";
		
		for ($i = 0; $i < mysql_num_rows($query); $i++) {
			echo "<input type='checkbox' name='cr' value=".$idscriterios[$i].">".$criterios[$i]."<br>";
		}
		echo"
				<button type='submit' value='create'>Create!
				<br></div>
				</form>
			</div>
		";
  }
}

?>
