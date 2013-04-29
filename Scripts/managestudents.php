<?php 

/*

Christian A. Rodriguez Encarnacion

Interface inicial para añadir o dar de baja a estudiantes

*/

session_start();

$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");
// Choose the database 'Avaluo'
if ($db) {
	mysql_select_db("Avaluo");
} else {
	echo "Could not connect to db";
	exit();
}

$coursequery = mysql_query("SELECT nombre_curso, curso_id from ProfesorImparte natural join Cursos where prof_id=$_SESSION[prof_id]");

 ?>

 <div id='content'>
 	<center>
 		<form>
 			<h3>Please choose a course:</h3>
 			<select name='course'>
 			<?php 
 			while ($row = mysql_fetch_array($coursequery)) {
 				echo '<option value='.$row["curso_id"].'>'.$row["nombre_curso"].'</option>' ;
 			}
 			 ?>
 			 </select> <br> <br>
 			 <h3>Add Students or Remove them:</h3>
 			 <select name='action'>
 			 	<option value='add'> Add Students</option>
 			 	<option value='remove'> Remove Students</option>
 			 </select> <br> <br>
 			 <input type='submit' class='btn btn-danger' name='add' value='Submit'> 
 		</form>
 	</center>
 </div>

 <script type="text/javascript">
$('form').submit(function() {
	var data = $(this).serializeArray();
  	var course = data[0].value;
  	var action = data[1].value;

  	if (action == 'add') {
  		var url = '../Scripts/addstudents.php?course='+course;
  	} else if (action == 'remove') {
  		var url = '../Scripts/removestudents.php?course='+course;
  	};

  $.get(url, function(html) {
	$("#content").hide()
	$("#content").replaceWith(html)
  })
  return false;
});
 </script>