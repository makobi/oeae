<?php
/*
	Tahiri Laboy De Jesus
	Script para ver todas las rubricas
*/

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
} else {
	echo "Access Denied!";
	exit();
}

$globals = mysql_query("SELECT * FROM NombresRubricas ORDER BY nombre_rub;")
	or die(mysql_error());

if ($_SESSION['nombre_prof'] == 'Administrador') {
	$locals = mysql_query("SELECT * FROM NombresRubricasLocal NATURAL JOIN RubricaCreadaPor NATURAL JOIN Profesores order by prof_id")
		or die(mysql_error()); 	
} else {
	$locals = mysql_query("SELECT * FROM NombresRubricasLocal NATURAL JOIN RubricaCreadaPor where prof_id='$_SESSION[prof_id]'")
		or die(mysql_error()); 	
}



?>

<script type='text/javascript'>
		function ViewRubric(rubricID, type) {
			if (type == 'local') {
				flag = 1;
			} else {
				flag = 0;
			};
			url = '../Scripts/view_rubric.php?rub_id='+rubricID+'&type='+flag;
			$.get(url, function(html) {
				$('#content').hide()
				$('#content').replaceWith(html)
			})
		};
</script>

<div id='content'> 
	<center>

	<h3> Rubric Database (Choose a rubric to view more information) </h3> <br> <br>	

	<h4>

	<p>Global Rubrics:</p>	

	<?php while($res = mysql_fetch_array($globals)) : ?>	

		<a href='#' onClick='ViewRubric(<?php echo $res['rub_id']; ?>,"global")'><?php echo $res['nombre_rub']; ?></a><br>	

	<?php endwhile; ?>	

	<br><br><br>
		
	<?php if(mysql_num_rows($locals)>0) : ?>	

		<p>Local Rubrics:</p>		

		<?php while($res = mysql_fetch_array($locals)) :?>		

			<a href='#' onClick='ViewRubric(<?php echo $res['rublocal_id']; ?>, "local")'><?php echo $res['nombre_rub']; ?></a><br>		

		<?php endwhile; ?>	

	<?php endif; ?>	

	</h4>

	</center>
</div>

