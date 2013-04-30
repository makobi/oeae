<?php 
/*

Este script se encarga de añadir estudiantes a los cursos.

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

$request = $_SERVER['PHP_SELF']
?>
<!-- Si es la primera vez que se entra al script -->
<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') : ?>
<?php $_SESSION['course'] = $_GET['course']; ?>
<div id = 'content'>
		<center>
			<form name='students' action='<?php echo $request; ?>' method='POST' class='form-inline'>
			<br>
			<input type='submit' value='Add' class='btn btn-danger'>
			<h2>Enter the information of the students:</h2>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				<strong>Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Student #:	</strong><br>
				<input type='text' name='nombre[]'> <input type='text' name='numest[]'> <br> <br>
				
				<br> <br> <br> <br>
			</form>
			</center>
		</div>
<!-- Si ya se sometio la informacion -->
<?php else : ?>
<?php 

	$nombres = $_POST['nombre'];
	$numest = $_POST['numest'];

	$ids = array();

	// Primero guardo a los estudiantes, si es que no estan en la base de datos
	for ($i=0; $i < 10; $i++) { 
		if ($nombres[$i]) {
			$query = mysql_query("INSERT IGNORE INTO Estudiantes (nombre_est, no_est) values ('$nombres[$i]', '$numest[$i]')")
				or die(mysql_error());
			$select = mysql_fetch_array(mysql_query("SELECT est_id from Estudiantes where nombre_est='$nombres[$i]' and no_est='$numest[$i]'"));
			$ids[] = $select[0];
		}
	 }

	 // Luego los asocio al curso, si es que no han sido asociados todavia.
	foreach ($ids as $key => $est_id) {
		$res = mysql_fetch_array(mysql_query("SELECT mat_id FROM Matricula where curso_id='$_SESSION[course]' and est_id='$est_id' "));
		if(!$res[0]) {
			$insert = mysql_query("INSERT IGNORE INTO Matricula (est_id,curso_id,baja) values ('$est_id','$_SESSION[course]','0')")
				or die(mysql_error());	
		}
	}

	?>

	<script type="text/javascript">alert("Students have been added to the course!");</script>
<?php header('Location: ../Front-end/no-index.php'); ?>
<?php endif; ?>