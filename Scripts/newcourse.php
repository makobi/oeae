<?php
/*
	Tahiri Laboy De Jesus
	Script para crear curso

	- Falta verificar que no se someta en blanco.
	- Cambiar programa a dropdown.
*/

$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

if ($link) {
	mysql_select_db("Avaluo");
} else {
	echo "Access Denied!";
	exit();
}

session_start();
$pid = $_SESSION['prof_id']; // si no esta set uso $_SESSION['email']

echo "<html>";

// Primera vez que se entra al script
if ($_SERVER['REQUEST_METHOD'] != 'POST') {	

	$request = $_SERVER['PHP_SELF'];

	echo "
		<div id = 'content'>
		<center>
			<form name='newcourse' action='".$request."' method='POST' 
			onSubmit = 'checkform()' class='form-inline'>
			<br>
			<p>Enter the information for the new course:</p>
				Course Name:	<br><input type='text' name='nombre'> <br>
				Course Code: 	<br><input type='text' name='codificacion'> <br>
				Secction: 		<br><input type='text' name='seccion' value='OU1'> <br>
				College: 		<br>
				<select name = 'facultad' id = 'select1'>
					<option value='ARQU'>Architecture</option>
					<option value='ADMI'>Bussiness Administration</option>
					<option value='COMU'>Comunication</option>
					<option value='EDUC'>Education</option>
					<option value='GENR'>General Studies</option>
					<option value='HUMA'>Humanities</option>
					<option value='CNAT'>Natural Sciences</option>
     				<option value='SOCI'>Social Sciences</option>					
				</select><br>
				Program: 		<br><input type='text' name='programa'> <br>
				<br>
				<button type='submit' value='create'>Create!
				<br>
			</form>
			</center>
		</div>
		</html>
		";

}
// Una vez se ha sometido la peticion
else {
	// Si tenemos los parametros necesarios, procedemos a crear el curso.
	if (!empty($_POST['nombre']) && !empty($_POST['codificacion']) 
		&& !empty($_POST['seccion']) && !empty($_POST['facultad'])
		&& !empty($_POST['programa'])) {

		// Guardo en la base de datos
		$query = mysql_query("INSERT INTO Cursos(nombre_curso,codificacion,seccion,
			fac_curso,prog_curso) VALUES (".$_POST['nombre'].",".$_POST['codificacion']
			.",".$_POST['seccion'].",".$_POST['facultad'].",".$_POST['programa'].");")
			or die (mysql_error());
	
	}
	// Si no se ha procesado debe mostrar el form nuevamente
	else echo "Entra la info, mamao!\n";
}
?>