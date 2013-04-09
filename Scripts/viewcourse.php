<?php 

/*
Christian A. Rodriguez Encarnacion

Este script es el que se llama cada vez que el profesor desea ver una de la actividades de algun curso
Va a guarda el id de la actividad y del curso para uso futuro, genera la rubrica de esta actividad utilizando
ese id y despliega la rubrica utilizada en esa actividad.
Tambien despliega 3 thumbnails utilizados para volver a la rubrica, ver datos agregados de la actividad, o
proceder a evaluar a los estudiantes.

Al final tambien desplegamos un script en jQuery para darle funcionalidad a los thumbnails.

REVISADO EL 15 DE MARZO
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

// Guardar el nombre de la actividad y el id
$_SESSION['nombre_act'] = $_GET['nombre_act'];
$_SESSION['act_id'] = $_GET['act_id'];

// Buscar el curso al cual pertenece la actividad
$courseidquery = "SELECT curso_id from ActividadesCurso where act_id=$_SESSION[act_id]";
$courseid = mysql_fetch_array(mysql_query($courseidquery));

// Guardar el id del curso de la actividad
$_SESSION['course_id'] = $courseid[0];

/***************************************************************************************************/
// Generar Rubrica
		$aid = $_SESSION['act_id'];

		// Busco el id de los criterios asociados a esa rubrica
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

// Primero se despliegan los 3 thumbnails
$table=				'<div id="content"><center>
					<table id="thumb0">
						<tr>
							<td>
					<ul class="thumbnails">
					  <li id="displayrubric">
					    <a href="#" class="thumbnail">
					    	<h3>Rubrics</h3>
					     </a>
					  </li>
					   <li id="thumb2">
					    <a href="#" class="thumbnail" >
					    	<h3>Results</h3>
					     </a>
					  </li>

					  <li id="students">
					    <a href="#" class="thumbnail" id="'.$_SESSION['course_id'].'" >
					    	<h3>Students</h3>
					     </a>
					  </li>
					  
					</ul>
				</td>
				</tr>
				</table>';

// Aqui se comienza a generar la tabla de la rubrica
$table=$table." <h1>".$_SESSION['nombre_act']."
				<form name='delete'>
				<input type='submit' value='Eliminar Actividad' class='btn btn-danger'>
				</form>
				</h1>
							<table id='rubrica'><tr>
				<form name='edit'>
				<td><input type='submit' value='Editar' class='btn btn-primary'></td>
				</form>
				<td>1-2</td>
				<td>3-4</td>
				<td>5-6</td>
				<td>7-8</td>
			  </tr>";

// Cada fila de la rubrica representa un criterio
for ($i=0; $i < $crit_qty; $i++) {
		$table=$table."<tr>
				<td><p>".$criterios[$cids[$i]]."</p>
				</td>
				<td>".$descripcion[$cids[$i]][2]."</td>
				<td>".$descripcion[$cids[$i]][4]."</td>
				<td>".$descripcion[$cids[$i]][6]."</td>
				<td>".$descripcion[$cids[$i]][8]."</td>
			  </tr>";
}

// Se despliega el contenido de la actividad
echo $table."</table>
						</center> 	</div>
			<script type='text/javascript'>

			$('#students a').on('click', function() {
				var course = $(this).attr('id');
				var url = '../Scripts/students.php?course_id='+course;
				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})
			});

			$('form[name=edit]').submit( function() {
				var url = '../Scripts/editrubric.php';

				$.get(url, function(html) {
					$('#content').hide()
					$('#content').replaceWith(html)
				})

				return false;
			});

			$('form[name=delete]').submit( function() {
				var url = '../Scripts/deleteactivity.php';

				$.get(url, function(res) {
					alert(res);
					window.location.replace('./no-index.php');
				})

				return false;
			});
			</script>
			";

 ?>
