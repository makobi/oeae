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
<?php
$_SESSION['course'] = $_GET['course']; 

$res = mysql_query("SELECT nombre_est, est_id from Matricula natural join Estudiantes where curso_id='$_SESSION[course]'");

?>
<div id = 'content'>
		<center>
			<form action='<?php echo $request; ?>' method='POST' class='form-inline'>
			<br>
			<input type='submit' value='Remove' class='btn btn-danger'>
			<h2>Select the students you want to remove:</h2>
			<?php while($row=mysql_fetch_array($res)) : ?>
			<h3><input type='checkbox' name='students[]' value='<?php echo $row['est_id']; ?>'><?php echo "     ".$row['nombre_est']; ?></h3>
			<?php endwhile; ?>
				
				<br> <br> <br> <br>
			</form>
			</center>
		</div>
<!-- Si ya se sometio la informacion -->
<?php else : ?>
<?php 

	$ids = $_POST['students'];

	foreach ($ids as $id) {
		$query = mysql_query("UPDATE Matricula set baja=1 where est_id='$id' and curso_id='$_SESSION[course]'");
	}

?>

	<script type="text/javascript">alert("Students have been deleted from the course!");</script>
<?php header('Location: ../Front-end/no-index.php'); ?>
<?php endif; ?>