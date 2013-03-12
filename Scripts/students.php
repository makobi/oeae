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

$curso_id = $_SESSION['course_id'];

// Select students query
$studentquery = "SELECT nombre_est, est_id FROM Estudiantes natural join Matricula where curso_id=$curso_id";
$students = mysql_query($studentquery);

// Generar Rubrica
		$aid = $_SESSION['act_id'];

		// Busco el id de los criterios asociados a esa rubrica
		$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN Rubricas WHERE act_id = '$aid'")
					or die(mysql_error());

		// Verifica que hayan resultados
		$crit_qty = mysql_num_rows($query1); 
		if ($crit_qty > 0) {
			$cids = array();
			while ($result = mysql_fetch_array($query1)) {
				$cids[] = $result["crit_id"];
			}
		}

		$criterios = array();
			foreach ($cids as $cid) {
				//Busco los nombres de los criterios
				$query2 = mysql_query("SELECT nombre_crit FROM Criterios WHERE crit_id = '$cid'")
					or die(mysql_error());
				$result = mysql_fetch_array($query2);
				$criterios[$cid] = $result["nombre_crit"];
			}


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
			<table id="grading">
					<thead> <!-- Begins Header row -->
						<td>
							<p>Estudiantes</p>
						</td>';

for ($i=0; $i < $crit_qty; $i++) {
		$content=$content."<td>
							<p>".$criterios[$cids[$i]]."</p>
						</td>";
}

$content=$content."<td>
						<p>Total</p>
					</td>
					</thead> <!-- Ends Header row -->
								<tbody>
								<form>";

// Aqui empiezan a desplegarse los estudiantes
while ($row = mysql_fetch_array($students)) {

	// Primero el nombre del estudiante
	$content = $content."<tr> <!-- Begins row -->
										<td>
											<p>$row[0]</p>
										</td>";

	for ($i=0; $i < $crit_qty; $i++) { 
		$content=$content."<td>
							<select class='styled-select' name='".$row[1]."y".$cids[$i]."'>
							<option value='nul'>N/A</option>
							<option value='0'>0</option><option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
							<option value='6'>6</option>
							<option value='7'>7</option>
							<option value='8'>8</option>
							</select>
							</td>";
	}


	// Query para sacar el mat_id de ese estudiante en ese curso
	$matquery = mysql_query("SELECT mat_id from Matricula where curso_id=$curso_id[0] and est_id=$row[1]");
	$mat = mysql_fetch_array($matquery);
	$mat_id = $mat[0];

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

	$content=$content."<td>
							$score/".strval($crit_qty*8)."
							</td>
						</tr> <!-- Ends row -->";

}

// Concatenar los scripts de jQuery relevantes a esta data.
$content = $content."</tbody>
								<tfoot>
									<td>
										<input type='submit' value='Submit'>
									</td>
								</tfoot></form>
							</table></center></div>
			<script type='text/javascript'>

			$('#students a').on('click', function() {
				var course = $(this).attr('id');
				var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/students.php?course_id='+course;
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})

			});

			$('form').submit(function () {

				var data = $(this).serialize();
				
				var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/addeval.php?'+data

				$.get(url, function(html) {
					alert(html)
				})

				return false;
			});
			</script>";

// Desplegar todo
echo $content;

?>