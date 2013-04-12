<?php
/*
	Christian A. Rodriguez
	
	Script de crear rubricas para profesores
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
$content = "<script type='text/javascript'>
			function validateCheckBoxes() {
		        var isValid = false; 
        		var allRows = document.getElementsByTagName('input');
        		for (var i=0; i < allRows.length; i++) {
        		    if (allRows[i].type == 'checkbox' && allRows[i].name == 'cr[]') {
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

	$content = $content. "
		<div id = 'content'>
		<center>
			<form name='nueva_rub' action='".$me."' method='POST' 
			onSubmit = 'checkform()' class='form'>
			<div><br>
			<table>
			<tr>
			<td>			
			<p><strong>Indique el nombre de la rubrica y seleccione los criterios que desea tener</strong></p>
			</td>
			</tr>
			<tr>
			<td>
			Rubric Name: <input type = 'text' name = 'rname'><br><br>
			Criterio - Dominios(s)
			<br><br>
			</td>
			</tr>";

	for ($i = 0; $i < mysql_num_rows($query); $i++) {
		$domquery = mysql_query("SELECT DISTINCT nombre_dom FROM Dominios NATURAL JOIN CriterioPertenece WHERE crit_id=".$idscriterios[$i])
				or die(mysql_error());

		$content = $content. "<tr>
			<td>
			<label class='checkbox'>
			<input type='checkbox' name='cr[]' value=".$idscriterios[$i].">".$criterios[$i]." -";

			$doms = "";
		while ($row = mysql_fetch_array($domquery)) {
			$doms = $doms." ".$row[0].",";
		}

		$content = $content.rtrim($doms,",");
		$content = $content	."
			</label>
			</tr>
			</td>";
	}
	$content = $content."<br><br>
			<tr>
			<td>
		<button type='submit' value='create' class='btn btn-primary'>Create!
		</tr>
			</td>
		</table>
			<br></div>
			</form>
			</center>
		</div>
		";
echo $content;

}
// Una vez se ha sometido la peticion
else {
  // Si tenemos los parametros necesarios, procedemos a crear.
  if (!empty($_POST['rname']) && !empty($_POST['cr'])) {
	$crits = array();
	$prof_id = $_SESSION['prof_id'];
	$rname = array_shift($_POST);

	foreach($_POST['cr'] as $critid) {
		$crits[] = $critid;
	}

	// Busco el id de la ultima rubrica en la base de datos
	$query = mysql_query("SELECT MAX(rublocal_id) AS ultima FROM RubricaLocal;") 
	or die (mysql_error());
	$result = mysql_fetch_array($query);
	$newrid = $result["ultima"] + 1;

	// Guardo nombre de la rubrica
	$query = mysql_query("INSERT INTO NombresRubricasLocal(rublocal_id, nombre_rub)
		VALUES('$newrid','$rname');") or die (mysql_error());

	
	// Guardo la nueva rubrica
	foreach ($crits as $cid) {
		$query = mysql_query("INSERT INTO RubricaLocal(rublocal_id,crit_id,prof_id) VALUES
			('$newrid','$cid','$prof_id');") 
			or die (mysql_error());
	}

	header( 'Location: ../Front-end/no-index.php' ) ;
	
  }
  // Si no los tenemos, volvemos a mostrar el form.
  else {
		$me = $_SERVER['PHP_SELF'];
		
		// Arregle temporero al error de los credenciales vacio
		header( 'Location: ../Front-end/no-index.php' ) ;

		$content = $content. "
			<div id = 'content'>
	
				<form name='nueva_rub' action='".$me."' method='POST' 
				onSubmit = 'checkform()'>
				<div><br>
				Rubric Name: <input type = 'text' name = 'rname'><br>";
		
		for ($i = 0; $i < mysql_num_rows($query); $i++) {
			$content = $content. "<input type='checkbox' name='cr' value=".$idscriterios[$i].">".$criterios[$i]."<br>";
		}
		$content = $content."
				<button type='submit' value='create'>Create!
				<br></div>
				</form>
			</div>
		";
		echo $content;
  }
}

?>
