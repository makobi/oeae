<?php
/*
	Tahiri Laboy De Jesus
	Script para ver todas las rubricas
*/

$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

//session_start();

if ($link) {
	mysql_select_db("Avaluo");
} else {
	echo "no salio";
	exit();
}
	
$nombresrubricas = array();

// Se generan todos los nombres de las rubricas
$query = mysql_query("SELECT * FROM NombresRubricas ORDER BY nombre_rub;")
	or die(mysql_error());
while($result = mysql_fetch_array($query)) {
	$nombresrubricas[] = $result["nombre_rub"];
	$rubids[] = $result["rub_id"];
}

// Desplegar
echo"<div id='content'> <center>
	<p> Rubric Database
	<p> Choose one of the rubrics:<br>";

for ($i = 0; $i < mysql_num_rows($query); $i++) {
	echo "<a href='LinkAViewRubricConId".$rubids[$i]."'>".$nombresrubricas[$i]."</a><br>"; 
}

echo"</p>

	<form action='createrubric.php'>
		<button type='submit' value='Create Rubric'>Create Rubric
	</form>

	 </center></div>";
?>
