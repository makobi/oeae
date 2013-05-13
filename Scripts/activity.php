<?php  

/*
Christian A. Rodriguez Encarnacion
Este script se activa cuando el profesor desea añadir una actividad. Contiene una forma que le permite
al profesor someter los credenciales de la actividad.

*/

/*
Revisado el 14 de marzo (Tahiri)
Incluir query que permita escoger tambien de las Rubricas Locales. 
*/

session_start();

$_SESSION['curso_id']=$_GET['curso_id'];

 $db = mysql_connect("localhost","nosotros","oeaeavaluo2013");
// Choose the database 'Avaluo'
if ($db) {
	mysql_select_db("Avaluo");
} else {
	echo "Could not connect to db";
	exit();
}

// Select the distinct Rubrics from the database
$query = mysql_query("SELECT rublocal_id, nombre_rub FROM NombresRubricasLocal natural join RubricaCreadaPor where prof_id='$_SESSION[prof_id]'");
$cursoquery = mysql_query("SELECT nombre_curso FROM Cursos where curso_id=".$_SESSION['curso_id']);
$query2 = mysql_query("SELECT rub_id, nombre_rub FROM NombresRubricas");



$curso = mysql_fetch_array($cursoquery);

$output = "
<div id='content'>
<center>
<h2>Crear Actividad: ".$curso[0]."</h2>
<form>
	Nombre de la Actividad: <br>
	<input type='text' name='nombre_act'> <br>
	Seleccione Rubrica para la actividad <br>
	<select name='rub_id'>";

while ($row = mysql_fetch_array($query)) {
		$output = $output."<option value='l,".$row[0]."'>Local - ".$row[1]."</option><br>";
	} 

while ($res = mysql_fetch_array($query2)) {
	$output = $output."<option value='g,".$res[0]."'>Global - ".$res[1]."</option><br>";
}

$output = $output."</select> <br>
	Logro Esperado (1-100) <br>
	<input type='text' name='logro_esperado'> <br>
	Procentaje de Estudiantes (1-100) <br>
	<input type='text' name='estudiantes_logro'> <br>
	<input type='Submit' value='Crear Actividad'>
</form>
</center>
</div>

<script type='text/javascript'>

$('form').submit(function() {
  var data = $(this).serializeArray();
  var nombre_act = data[0].value;
  var rubrica = data[1].value.split(',');
  var rub_id = rubrica[1];
  var type = rubrica[0];
  var logro_esperado = data[2].value;
  var estudiantes_logro = data[3].value;

  var url = '../Scripts/add.php?nombre_act='+nombre_act+'&rub_id='+rub_id+'&logro_esperado='+logro_esperado+'&estudiantes_logro='+estudiantes_logro+'&type='+type;

   $.get(url, function(res) {
   	alert(res);
 	 window.location.replace('../Front-end/no-index.php');
   })

  return false;
});

</script>

";

echo $output;

 ?>	
