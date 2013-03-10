<?php 

/*
Christian A. Rodriguez Encarnacion

Este script despliega a los estudiantes matriculados en el curso perteneciente a la actividad, junto a la suma de
sus puntos utilizando la rubrica de la actividad. Para evaluar a los estudiantes solo debes hacer click encima del
nombre del estudiante que desee evaluar.

*/


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

$curso_id = $_GET['course_id'];

// Select students query
$studentquery = "SELECT nombre_est, est_id FROM Estudiantes natural join Matricula where curso_id=$curso_id";
$students = mysql_query($studentquery);

// Primero los 3 thumbnails
$content='
				<div id="content"><center>
					<table id="thumb0">
						<tr>
							<td>
					<ul class="thumbnails">
					  <li id="thumb1">
					    <a href="#" class="thumbnail" >
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://renewable.uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Rubrics</h3>
					     </a>
					  </li>
					   <li id="thumb2">
					    <a href="#" class="thumbnail" >
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Graphs</h3>
					     </a>
					  </li>

					  <li id="students">
					    <a href="#" class="thumbnail" id="'.$curso_id[0].'" >
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://ccom.uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Students</h3>
					     </a>
					  </li>
					  
					</ul>
				</td>
				</tr>
				</table>
				<h1>'.$_SESSION['nombre_act'].'</h1>
			<ul id="studentlist">';

// Aqui empiezan a desplegarse los estudiantes
while ($row = mysql_fetch_array($students)) {

	// Primero el nombre del estudiante
	$content = $content."<li><a href='#' class='evaluacion'><h2 id='".$row[1]."'>".$row[0]."</h2></a>"; 
	
	// Query para sacar el mat_id de ese estudiante en ese curso
	$matquery = mysql_query("SELECT mat_id from Matricula where curso_id=$curso_id[0] and est_id=$row[1]");
	$mat = mysql_fetch_array($matquery);
	$mat_id = $mat[0];

	// Busco el id de los criterios asociados a esa rubrica
	$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN Rubricas WHERE act_id = '$_SESSION[act_id]'")
			or die(mysql_error());

	// Verifica que hayan resultados
	$crit_qty = mysql_num_rows($query1); 
	if ($crit_qty > 0) {
		$cids = array();
		while ($result = mysql_fetch_array($query1)) {
			$cids[] = $result["crit_id"];
		}
	}

	// Busco el rub_id
	$query2 = mysql_query("SELECT rub_id FROM Actividades where act_id='$_SESSION[act_id]'");
	$rubrica = mysql_fetch_array($query2);
	$rub_id = $rubrica[0];

	// Acumulador para nota actual del estudiante
	$score=0;

	// Sumar puntos obtenidos por cada criterio al acumulador
	for ($i=0; $i < $crit_qty; $i++) { 
	$eval = "SELECT ptos_obtenidos from Evaluacion 
			where act_id=$_SESSION[act_id] and crit_id=".$cids[$i]." and mat_id=$mat_id and rub_id=$rub_id";
	$res = mysql_query($eval);
	$puntos = mysql_fetch_array($res);
	$score = $score + intval($puntos[0]);
	}

	// Desplegar nota actual del estudiante
	$content = $content."<h2>Score:$score/".strval($crit_qty*8)."</h2></li><br>";
}

// Concatenar los scripts de jQuery relevantes a esta data.
$content = $content."</ul></center></div>
			<script type='text/javascript'>

			$('#students a').on('click', function() {
				var course = $(this).attr('id');
				var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/students.php?course_id='+course;
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})

			});

			$('.evaluacion').on('click', function () {
				var est_id = $(this).children('h2').attr('id');
				console.log(est_id)
				var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/eval.php?est_id='+est_id;

				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})
			});
			</script>";

// Desplegar todo
echo $content;

?>