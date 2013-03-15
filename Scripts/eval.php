<?php 

/*
Christian A. Rodriguez Encarnacion

Este script es llamado cada vez que el profesor desee evaluar a un estudiante. Desplega el nombre del estudiante
y la rubrica del curso, esta vez con botones para escoger la puntuacion del estudiante, y someter dicha puntuacion.
Si el profesor no ha evaluado antes, se crea la entrada en la base de datos, si ha evaluado antes se hace un
update a la evaluacion actual.

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

// Id del estudiante a ser evaluado
$est_id = $_GET['est_id'];

// Query para sacar el nombre del estudiante
$studentnamequery = "SELECT nombre_est from Estudiantes where est_id=$est_id";
$studentname = mysql_fetch_array(mysql_query($studentnamequery));
$nombre_est = $studentname[0];


/***************************************************************************************************/
// Generar Rubrica
		$aid = $_SESSION['act_id'];

		// Busco el id de los criterios asociados a esa rubrica
/*		$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN Rubricas WHERE act_id = '$aid'")
					or die(mysql_error());
*/
				
		$query1 = mysql_query("SELECT crit_id FROM Actividades NATURAL JOIN RubricaLocal WHERE act_id = '$aid'")
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
			
			$descripcion = array(array());
			$valor = array();

			foreach ($cids as $cid) {
				$query3 = mysql_query("SELECT descripcion, valor FROM EscalaCriterio
									   WHERE crit_id = $cid ORDER BY valor;")
						or die(mysql_error());
				while ($result = mysql_fetch_array($query3)) {
					$valor = $result["valor"];
					$descripcion[$cid][$valor] = $result["descripcion"];
				}
			}
/***************************************************************************************************/

// Primero los 3 thumbnails
$table = '<div id="content"><center>
					<table id="thumb0">
						<tr>
							<td>
					<ul class="thumbnails">
					  <li id="displayrubric">
					    <a href="#" class="thumbnail">
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
					    <a href="#" class="thumbnail" id="'.$_SESSION['course_id'].'" >
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://ccom.uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Students</h3>
					     </a>
					  </li>
					  
					</ul>
				</td>
				</tr>
				</table>';

// Primera fila de la rubrica
$table=$table." <h1>".$_SESSION['nombre_act'].": ".$nombre_est."</h1>
				<form>
							<table id='rubrica'><tr>
				<td><input type='Submit' value='Submit Evaluation'></td>
				<td>1-2</td>
				<td>3-4</td>
				<td>5-6</td>
				<td>7-8</td>
			  </tr>";

// Por cada criterio desplegar una fila con las puntuaciones, pero esta vez con botones para escoger
for ($i=0; $i < $crit_qty; $i++) {
		$table=$table."<tr>
				<td><p>".$criterios[$cids[$i]]."</p>
				</td>
				<td>".$descripcion[$cids[$i]][2]."<br>
					<input type=radio name='".$cids[$i]."' value=1> 1
					&nbsp &nbsp
					<input type=radio name='".$cids[$i]."' value=2> 2
				</td>
				<td>".$descripcion[$cids[$i]][4]." <br>
					<input type=radio name='".$cids[$i]."' value=3> 3
					&nbsp &nbsp
					<input type=radio name='".$cids[$i]."' value=4> 4
				</td>
				<td>".$descripcion[$cids[$i]][6]." <br>
					<input type=radio name='".$cids[$i]."' value=5> 5
					&nbsp &nbsp
					<input type=radio name='".$cids[$i]."' value=6> 6
				</td>
				<td>".$descripcion[$cids[$i]][8]." <br>
					<input type=radio name='".$cids[$i]."' value=7> 7
					&nbsp
					<input type=radio name='".$cids[$i]."' value=8> 8
				</td>
			  </tr>
			  ";
}

// Desplegar todo, junto con el jQuery pertinente
echo $table."</table> </form>
						</center> 	</div>
			<script type='text/javascript'>

			$('#students a').on('click', function() {
				var course = $(this).attr('id');
				var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/students.php?course_id='+course;
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})

			});

			$('form').submit(function() {
  				var data = $(this).serialize();

				var url = 'http://ada.uprrp.edu/~chrodriguez/oeae/Scripts/addeval.php?'+data+'&est_id=".$est_id."';							

				$.get(url, function(res) {
					alert(res);
				})

				return false;
			});

			</script>
			";

 ?>
