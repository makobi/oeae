<?php 

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


$_SESSION['nombre_act'] = $_GET['nombre_act'];
$_SESSION['act_id'] = $_GET['act_id'];

$courseidquery = "SELECT curso_id from ActividadesCurso where act_id=$_SESSION[act_id]";
$courseid = mysql_fetch_array(mysql_query($courseidquery));

$_SESSION['course_id'] = $courseid[0];


$table=				'<div id="content"><center>
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

$table=$table." <h1>".$_SESSION['nombre_act']." ".$_SESSION['act_id']."</h1>
							<table id='rubrica'><tr>
				<td><button type='button' onclick='change_number_rows()'>Edit</button></td>
				<td>1-2</td>
				<td>3-4</td>
				<td>5-6</td>
				<td>7-8</td>
			  </tr>";
for ($i=0; $i < 5; $i++) { 
		$table=$table."<tr>
				<td><p>Nombre</p>
				</td>
				<td>Descripcion</td>
				<td>Descripcion</td>
				<td>Descripcion</td>
				<td>Descripcion</td>
			  </tr>";
}
echo $table."</table>
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
			</script>
			";

 ?>