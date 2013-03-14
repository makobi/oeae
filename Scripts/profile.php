<?php 

/*
Christian A. Rodriguez Encarnacion
Este script se llama cuando el usuario hace click en su nombre, para poder volver a enseñar su informacion
de perfil.

SE DEBE EDITAR PARA QUE EL USUARIO PUEDA EDITAR SU INFORMACION.

*/

session_start();

echo '<div id="content">
						<center>

						<h1>'.$_SESSION['nombre_prof'].'</h1>
						<h2>'.$_SESSION['email'].'</h2>
						<h2>'.$_SESSION['fac_prof'].'</h2>
						<h2>'.$_SESSION['dpto_prof'].'</h2> <br>

						</center>
					</div>'

 ?>