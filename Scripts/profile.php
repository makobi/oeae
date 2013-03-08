<!-- 
Christian A. Rodriguez Encarnacion
Este script es el profile page de los profesores. Hago la validacion
del login aqui y si es un profesor valido le desplego su informacion
incluyendo sus cursos.
 -->

<?php session_start(); 

// Connect to the Database
$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
  mysql_select_db("Avaluo");
} else {
  echo "no salio";
  exit();
}

// Credencials for profesor login
$email = $_POST['email'];
$passwd = md5($_POST['passwd']);

// Query to check for credentials
$loginquery = "SELECT passwd, prof_id, nombre_prof FROM Profesores where email='$email'";
$credentials = mysql_fetch_array(mysql_query($loginquery));

// If credential are not valid, send back to login page
if ($credentials['passwd'] !== $passwd) {
	header('Location: http://ada.uprrp.edu/~chrodriguez/index.php');	
	exit();
}

// Save credential in the session variable
$_SESSION['prof_id'] = $credentials['prof_id'];
$_SESSION['nombre_prof'] = $credentials['nombre_prof'];
$_SESSION['email'] = $email;

$profinfo = "SELECT fac_prof, dpto_prof FROM Profesores where prof_id=$_SESSION[prof_id]";
$prof = mysql_fetch_array(mysql_query($profinfo));
 ?>

<html>
<head>
	<title>Professor's Profile</title>
</head>
<body>
	<h1><? echo "$_SESSION[nombre_prof]"; ?></h1>
	<h2> <?php echo "$_SESSION[email]"; ?></h2>
	<h2> <?php echo "$prof[fac_prof]"; ?></h2>
	<h2> <?php echo "$prof[dpto_prof]"; ?></h2> <br>

	<hr>

	<h3>Cursos</h3>

	<ul>
	<?php 
	$cursosquery = "SELECT nombre_curso, codificacion FROM Profesores NATURAL JOIN ProfesorImparte natural join Cursos where prof_id=$_SESSION[prof_id]"; 
	$cursos = mysql_query($cursosquery);
	while ($row = mysql_fetch_array($cursos)) {
		echo "<li>".$row[0]." ".$row[1]."</li>";		
	} 
	?>
	</ul>

</body>
</html>