<!-- 
Christian A. Rodriguez Encarnacion
Por ahora este codigo lo que hace es deslplegar los estudiantes del
primer curso, pero cuando Alex termine el display de los estudiantes
lo hago mas dinamico.
 -->

<?php 
session_start();

// Connect to the Database
$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
  mysql_select_db("Avaluo");
} else {
  echo "no salio";
  exit();
}

$curso_id = 1;

// Select students query
$studentquery = "SELECT nombre_est FROM Estudiantes natural join Matricula where curso_id=$curso_id";
$students = mysql_query($studentquery);

?>

<html>
<head>
	<title>Students</title>
</head>
<body>
	<h2>Matematicas Discretas</h2>
	<ul>
		<?php 
		while ($row = mysql_fetch_array($students)) {
			echo "<li>".$row[0]."</li>";
		}
		 ?>
	</ul>
</body>
</html>