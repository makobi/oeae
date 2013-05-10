<?php

session_start();

/* Parametros para conexion a la base de datos */
$server         = 'localhost';
$user           = 'nosotros';
$password       = 'oeaeavaluo2013';
$database       = 'Avaluo';
$link           = mysql_connect($server, $user, $password);

/* Se intenta la conexion, de ser infructuosa se deniega el acceso. */
if ($link) {
	mysql_select_db("Avaluo");
} 
else {
	echo "Access Denied!";
	exit();
}

$type= $_GET['type'];

// Listado por escuela o facultad
if ($type == "college") {
	$list="<h2> Select a School or College: </h2>
		  <br> <br>
			<p> School of Architecture </p>
			<p> School of Communication </p>
			<p> College of General Studies </p>
			<p> College of Humanities </p>
			<p> College of Education </p>
			<p> College of Business Administration </p>
			<p> College of Natural Sciences </p>
			<p> College of Social Sciences </p>
		";
}

// Listado por programa
else if ($type == "program") {
	$list="	<h2> Select a Program: </h2>
		  <br>
			<p><b> School of Architecture </b></p>
				<p> Environmental Design </p>
			<br>
			<p><b> School of Communication  </b></p>
				<p> Audiovisual Communication </p>
				<p> Information and Journalist </p>
				<p> Public Relations and Advertisement </p>
			<br>
			<p><b> College of General Studies  </b></p>
				<p> Interdisciplinary Program in General Studies </p>
			<br>
			<p><b> College of Humanities  </b></p>
				<p> Art History </p>
				<p> Comparative Literature </p>
				<p> Performing Arts </p>
				<p> English Linguistics and Communication </p>
				<p> English Literature </p>
				<p> History of Europe </p>
				<p> History of the Americas </p>
				<p> Fine Arts </p>
				<p> Modern Languages </p>
				<p> Interdisciplinary Studies </p>
				<p> Hispanics Studies </p>
				<p> Music </p>
				<p> Philosophy </p>
			<br>
			<p><b> College of Education  </b></p>
				<p> Family Ecology - Pre-School Education </p>
				<p> Elementary Education – K-3 </p>
				<p> Elementary Education – 4-6 </p>
				<p> Elementary Education – TESOL </p>
				<p> Elementary Education – Special Education </p>
				<p> Secondary Education – Art </p>
				<p> Secondary Education – Biology </p>
				<p> Secondary Education – Family Ecology </p>
				<p> Secondary Education – Business Office Management Education </p>
				<p> Secondary Education – Technical Industrial Education </p>
				<p> Secondary Education – Spanish </p>
				<p> Secondary Education – Physics </p>
				<p> Secondary Education – Mathematics </p>
				<p> Secondary Education – Chemistry </p>
				<p> Secondary Education – Industrial Arts </p>
				<p> Secondary Education – General Science </p>
				<p> Secondary Education – Business Accounting Education </p>
				<p> Secondary Education – Physical Education </p>
				<p> Secondary Education – TESOL </p>
				<p> Secondary Education – Social Sciences </p>
				<p> Secondary Education – History </p>
				<p> Secondary Education – Music </p>
				<p> Secondary Education – Theater </p>
				<p> Recreation </p>
				<p> Family and Community Education </p>
			<br>
			<p><b> College of Business Administration  </b></p>
				<p> Office System Management </p>
				<p> Accounting </p>
				<p> Computerized Information Systems </p>
				<p> Marketing </p>
				<p> Finance </p>
				<p> Operations Management </p>
				<p> Human Resources </p>
				<p> Statistics </p>
				<p> General Program </p>
			<br>
			<p><b> College of Natural Sciences  </b></p>
				<p> Biology </p>
				<p> Interdisciplinary Program in Natural Sciences </p>
				<p> Chemistry </p>
				<p> Computer Science </p>
				<p> Mathematics </p>
				<p> Environmental Sciences </p>
				<p> Nutrition and Dietetics </p>
				<p> Physics </p>
			<br>
			<p><b> College of Social Sciences  </b></p>
				<p> Anthropology </p>
				<p> Economics </p>
				<p> Geography </p>
				<p> General Program in Social Sciences </p>
				<p> Labor Relations </p>
				<p> Political Science </p>
				<p> Psychology </p>
				<p> Social Work </p>
				<p> Sociology </p>
";
				
}
// Listado por cursos - Solo se muestran los cursos que estan en la base de datos
else if ($type == "course") {

	$list = "<h2> Select a Program: </h2>
		  <br>";
	
	$colleges = mysql_query("Select distinct fac_curso from Cursos order by fac_curso;") or die(mysql_error());

	// Para todas las facultades en la base de datos...
	while ($col_res = mysql_fetch_array($colleges)) {
		$fac = $col_res["fac_curso"]; 
		// Despliego nombre de la facultad
		if ($fac =='ARQU') 	 $list.= "<p><b> School of Architecture</b></p>";
		else if ($fac =='ADMI') $list.= "<p><b> College of Business Administration</b></p>";
		else if ($fac =='COMU') $list.= "<p><b> School of Communication</b></p>";
		else if ($fac =='EDUC') $list.= "<p><b> College of Education</b></p>";
		else if ($fac =='GENR') $list.= "<p><b> College of General Studies</b></p>";
		else if ($fac =='HUMA') $list.= "<p><b> College of Humanities</b></p>";
		else if ($fac =='CNAT') $list.= "<p><b> College of Natural Sciences</b></p>";
     	else if ($fac =='SOCI') $list.= "<p><b> College of Social Sciences</b></p>";
		
		$programs = mysql_query("Select distinct prog_curso from Cursos where fac_curso = '$fac'
			order by prog_curso;")
			or die(mysql_error());

		// Para todas los programas asociados a esa facultad...
		while ($prog_res = mysql_fetch_array($programs)) {
			$prog = $prog_res['prog_curso'];
			// Despliego nombre del programa
			$list.= "<p><i> $prog </i></p>";

			$courses = mysql_query("Select distinct codificacion, curso_id, nombre_curso from Cursos where
				prog_curso = '$prog' order by codificacion;") or die(mysql_error());

			// Para todas los programas asociados a esa facultad...
			while ($courses_res = mysql_fetch_array($courses)) {
				$cod = $courses_res['codificacion'];
				$nombre = $courses_res['nombre_curso'];
				$id = $courses_res['curso_id'];
				// Despliego link a agregados de cursos correspondientes
				$list.= "<p>
						 <a href='#' onClick='ViewResults(\"$type\",$id)'> $cod : $nombre </a>
						 </p>";
			}
			$list.="<br>";
		}
		$list.="<br>";
	}
}
else $list = "<p> Error: List type not set. </p>";

?>

<script type='text/javascript'>
	// Funcion que genera el url donde se genera la lista por tipo
	function ViewResults(type, id) {
		if (type == "course") {
			url = "../Scripts/resultsforcourse.php?course_id="+id;
		}
		else if (type == "program") {
			url = "";
		}
		else { // type == "college"
			url = "";
		};

		$.get(url, function(html) {
			$('#content').hide()
			$('#content').replaceWith(html)
		})
	};
</script>

<div id='content'> 
	<center>

	<?echo $list; ?>

	</center>
</div>
