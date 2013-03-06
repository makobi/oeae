
<html>
<head>

	<h1>Hello</h1>

</head>


<?php 

//session_start();

// Connect to the Database
$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
  mysql_select_db("Avaluo");
} else {
  echo "no salio";
  exit();
}


$cursosquery = "SELECT nombre_curso, codificacion FROM Profesores NATURAL JOIN ProfesorImparte natural join Cursos where prof_id=1"; 
$cursos = mysql_query($cursosquery);

while ($row=mysql_fetch_array($cursos)) {
		$string="
<li>
<a href='no-index.html' id='".$row[0]."'>
<div class='secction'> 
<div><img src='class_img.jpg' id='effect'></div>
<p>".$row[0]." ".$row[1]."</p>
</div></a><ul id='".$row[1]."'>";

$query = "SELECT nombre_act FROM ActividadesCurso natural join Actividades natural join Cursos where nombre_curso='Matematica Discreta'";

$activity = mysql_query($query);

if (mysql_num_rows($activity)>0) {
	while ($res=mysql_fetch_array($activity)) {
		$string = $string."
		<li>
		<a href='no-index.html'>
		<div class='secction2'>
		<div><img src='class_img.jpg' id='effect'>	</div>
		<p>".$res[0]."</p>
		</div></a></li>";
	}
}
										
			$string = $string."</ul></li>";
			echo $string;
				}

?>

