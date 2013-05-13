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

/* Listado por programa - 
Para record, ese else if me da verguenza ajena... */

else if ($type == "program") {

	$programs = array();

	// Query para verificar los diferentes programas en la base de datos
	$prog_query = mysql_query("Select distinct prog_curso from Cursos;") or die(mysql_error());
	while ($result = mysql_fetch_array($prog_query)) {
		$programs[] = $result['prog_curso'];
	}

	// Verifica si el programa existe en la base de datos. De ser cierto, activa url para ver agregados.
	function CheckProgram($type, $program, $programs) {
		
		if (in_array($program, $programs)) {
			$url="<p>
					<a href='#' onClick='ViewResults(\"$type\",\"$program\")'> $program </a>
				 </p>";
		}
		else $url = "";//"<p> $program </p>";

		return $url;
	}

	$list="	<h2> Select a Program: </h2>
		  <br>
			<p><b> School of Architecture </b></p>
				".CheckProgram ($type, 'Environmental Design',$programs)."
			<br>
			<p><b> School of Communication  </b></p>
				".CheckProgram ($type, 'Audiovisual Communication',$programs)."
				".CheckProgram ($type, 'Information and Journalist',$programs)."
				".CheckProgram ($type, 'Public Relations and Advertisement',$programs)."
			<br>
			<p><b> College of General Studies  </b></p>
				".CheckProgram ($type, 'Interdisciplinary Program in General Studies ',$programs)."
			<br>
			<p><b> College of Humanities  </b></p>
				".CheckProgram ($type, 'Art History',$programs)."
				".CheckProgram ($type, 'Comparative Literature',$programs)."
				".CheckProgram ($type, 'Performing Arts',$programs)."
				".CheckProgram ($type, 'English Linguistics and Communication',$programs)."
				".CheckProgram ($type, 'English Literature',$programs)."
				".CheckProgram ($type, 'History of Europe',$programs)."
				".CheckProgram ($type, 'History of the Americas',$programs)."
				".CheckProgram ($type, 'Fine Arts',$programs)."
				".CheckProgram ($type, 'Modern Languages',$programs)."
				".CheckProgram ($type, 'Interdisciplinary Studies',$programs)."
				".CheckProgram ($type, 'Hispanics Studies',$programs)."
				".CheckProgram ($type, 'Music',$programs)."
				".CheckProgram ($type, 'Philosophy',$programs)."
			<br>
			<p><b> College of Education  </b></p>
				".CheckProgram ($type, 'Family Ecology - Pre-School Education',$programs)."
				".CheckProgram ($type, 'Elementary Education – K-3',$programs)."
				".CheckProgram ($type, 'Elementary Education – 4-6',$programs)."
				".CheckProgram ($type, 'Elementary Education – TESOL',$programs)."
				".CheckProgram ($type, 'Elementary Education – Special Education',$programs)."
				".CheckProgram ($type, 'Secondary Education – Art',$programs)."
				".CheckProgram ($type, 'Secondary Education – Biology',$programs)."
				".CheckProgram ($type, 'Secondary Education – Family Ecology',$programs)."
				".CheckProgram ($type, 'Secondary Education – Business Office Management Education',$programs)."
				".CheckProgram ($type, 'Secondary Education – Technical Industrial Education',$programs)."
				".CheckProgram ($type, 'Secondary Education – Spanish',$programs)."
				".CheckProgram ($type, 'Secondary Education – Physics',$programs)."
				".CheckProgram ($type, 'Secondary Education – Mathematics',$programs)."
				".CheckProgram ($type, 'Secondary Education – Chemistry',$programs)."
				".CheckProgram ($type, 'Secondary Education – Industrial Arts',$programs)."
				".CheckProgram ($type, 'Secondary Education – General Science',$programs)."
				".CheckProgram ($type, 'Secondary Education – Business Accounting Education',$programs)."
				".CheckProgram ($type, 'Secondary Education – Physical Education',$programs)."
				".CheckProgram ($type, 'Secondary Education – TESOL',$programs)."
				".CheckProgram ($type, 'Secondary Education – Social Sciences',$programs)."
				".CheckProgram ($type, 'Secondary Education – History',$programs)."
				".CheckProgram ($type, 'Secondary Education – Music',$programs)."
				".CheckProgram ($type, 'Secondary Education – Theater',$programs)."
				".CheckProgram ($type, 'Recreation',$programs)."
				".CheckProgram ($type, 'Family and Community Education',$programs)."
			<br>
			<p><b> College of Business Administration  </b></p>
				".CheckProgram ($type, 'Office System Management',$programs)."
				".CheckProgram ($type, 'Accounting',$programs)."
				".CheckProgram ($type, 'Computerized Information Systems',$programs)."
				".CheckProgram ($type, 'Marketing',$programs)."
				".CheckProgram ($type, 'Finance',$programs)."
				".CheckProgram ($type, 'Operations Management',$programs)."
				".CheckProgram ($type, 'Human Resources',$programs)."
				".CheckProgram ($type, 'Statistics',$programs)."
				".CheckProgram ($type, 'General Program',$programs)."
			<br>
			<p><b> College of Natural Sciences  </b></p>
				".CheckProgram ($type, 'Biology',$programs)."
				".CheckProgram ($type, 'Interdisciplinary Program in Natural Sciences',$programs)."
				".CheckProgram ($type, 'Chemistry',$programs)."
				".CheckProgram ($type, 'Computer Science',$programs)."
				".CheckProgram ($type, 'Mathematics',$programs)."
	            ".CheckProgram ($type, 'Environmental Sciences',$programs)."
				".CheckProgram ($type, 'Nutrition and Dietetics',$programs)."
				".CheckProgram ($type, 'Physics',$programs)."

			<br>
			<p><b> College of Social Sciences  </b></p>
				".CheckProgram ($type, 'Anthropology ',$programs)."
				".CheckProgram ($type, 'Economics ',$programs)."
				".CheckProgram ($type, 'Geography ',$programs)."
				".CheckProgram ($type, 'General Program in Social Sciences ',$programs)."
				".CheckProgram ($type, 'Labor Relations ',$programs)."
				".CheckProgram ($type, 'Political Science ',$programs)."
				".CheckProgram ($type, 'Psychology ',$programs)."
				".CheckProgram ($type, 'Social Work ',$programs)."
				".CheckProgram ($type, 'Sociology ',$programs)."
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
			url = "../Scripts/resultsforprogram.php?prog_id="+id;
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
