<?php 

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
$query = mysql_query("SELECT distinct rub_id FROM Rubricas");
 
$output = "
<div id='content'>
<center>
<form>
	Nombre de la Actividad (Sin espacios por ahora): <br>
	<input type='text' name='nombre_act'> <br>
	Seleccione Rubrica para la actividad <br>
	<select name='rub_id'>";

while ($row = mysql_fetch_array($query)) {
		$output = $output."<option>".strval($row[0])."</option><br>";
	} 

$output = $output."</select> <br>
	Logro Esperado (1-100) <br>
	<input type='text' name='logro_esperado'> <br>
	<input type='Submit' value='Crear Actividad'>
</form>
</center>
</div>

<script type='text/javascript'>

$('form').submit(function() {
  var data = $(this).serializeArray();
  var nombre_act = data[0].value;
  var rub_id = data[1].value;
  var logro_esperado = data[2].value;

  var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/add.php?nombre_act='+nombre_act+'&rub_id='+rub_id+'&logro_esperado='+logro_esperado;

  $.get(url, function(res) {
 	window.location.replace('http://ada.uprrp.edu/~chrodriguez/oeae/Front-end/no-index.php');
  })

  return false;
});

</script>

";

echo $output;

 ?>	