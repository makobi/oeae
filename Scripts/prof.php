<?php  

/*
Christian A. Rodriguez Encarnacion
Este script solo desplega la forma para el administrador poder someter los credenciales de un profesor nuevo.
Esto se puede hacer sin php, despues lo cambio a un html solo.

*/

echo "<div id='content'>
	<center>
	<p>Enter Professor's information</p>
	<form method='post' action='newprof.php'>
		Nombre del Professor: <br>
		<input type='text' name='profname'> <br>
		Email: <br>
		<input type='text' name='profemail'> <br>
		Departamento: <br>
		<input type='text' name='profdept'> <br>
		Facultad: <br>
		<input type='text' name='proffaculty'> <br>
		<br>
		<input type='submit' class='btn btn-primary'>
	</form>
	</center>
</div>

		<script type='text/javascript'>

	$('form').submit( function() {
			var data = $(this).serialize();
			var url = '../Scripts/newprof.php?'+data;
			console.log(data);

		$.get(url, function(html) {
				alert('Professor in Database. Password: '+html)
			})

		return false;
		});
		</script>

";

?>
