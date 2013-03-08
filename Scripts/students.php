<?php 

/*Christian A. Rodriguez Encarnacion
Por ahora este codigo lo que hace es deslplegar los estudiantes del
primer curso, pero cuando Alex termine el display de los estudiantes
lo hago mas dinamico.*/


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
$studentquery = "SELECT nombre_est FROM Estudiantes natural join Matricula where curso_id=$curso_id";
$students = mysql_query($studentquery);

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

			<ul>';

while ($row = mysql_fetch_array($students)) {
	$content = $content."<h1><li>".$row[0]."</li></h1><br>";
}

$content = $content."</ul></center></div>";
echo $content;

?>