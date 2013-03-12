<?php 


session_start();

if($_SESSION['nombre_prof']!='Administrador') {
	header('LOCATION: ./index.php');
}

?>
<!doctype html> 
<html lang="en">

<!-- Comienza el head -->
<head>
	<meta charset="utf-8" />
	<title>Avaluo!!</title>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="bootstrap-responsive.css">
	<link rel="stylesheet" href="bootstrap.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="effects.js"></script>
<!-- 	 <script type="text/javascript" src="holder.js"></script> -->

	<script type="text/javascript">

		function abrir_cerrar(id){

		  	$(id).slideToggle('slow');	
	 	
	 	}

	</script>

</head>
<!-- Termina el head -->

<!-- Comienza el body -->
<body>
	<!-- Esto es la barra de arriba, que tiene el log-out -->
	<div id="top_bar">
		
		<a href="index.php" id="logout"><p>Logout</p></a>
	</div>
	<!-- Termina la barra -->

	<!-- Este wrapper contiene todo lo que esta debajo de la barra -->
	<div id="main_wrapper">

		<!-- Este es el navegador drop down que esta a la izquierda -->
		<div id="nav_drop">
			<!-- Aqui va todo lo que va en la parte izquierda -->
			<div class="title"> <p>Profile</p></div>
			<a href="#" ><div class="secction" id="profile"> 
				<div ><img src="person_purple.png" id="effect"></div>
				<p> <?php echo $_SESSION['nombre_prof'] ?> </p>
			</div></a>
			<div class="secction1" id="major"> 
				<div class="title"> <p>Options</p></div>
				<div class="secction1"> 
					<a href="#" class="prof"><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Add Professor</p>
					</div></a>
					<a href="#" class="rub"><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Create Rubric</p>
					</div></a>
					<a href="#" ><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Option Name Here</p>
					</div></a>
					<a href="#" ><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Option Name Here</p>
					</div></a>

				</div>
			</div>
			
		</div>
		<!-- Termina el navegador drop down -->

		<!-- Este es el contenedor que tiene todo lo que va a la derecha del navegador drop down-->
		<div id="main_sub">

			<!-- Esto contiene el outline/title -->
			<div id="top_main">
				<a href="#"><div id="show_hide"><img src="hide-show.png" id="effect"></div></a>

			</div>
			<!-- Termina contenedor-->

			<!-- Esto contiene la informacion principal -->
			<div id="main_content">
				<!-- Aqui va la informacion de las rubricas -->

					<!-- Este div es el que se renderea cada vez que cambiamos de actividad -->
					<div id="content">
						<center>

						<h1><? echo "$_SESSION[nombre_prof]"; ?></h1>
						<h2> <?php echo "$_SESSION[email]"; ?></h2>

						</center>
					</div>
					<!-- Aqui termina el div -->
					
			</div>
  	
 
  </div>
</div>
			</div>
			<!-- Termina contenido principal -->
			
		</div>
		<!-- Termina contenedor-->
	</div>
	<!-- Termina el wrapper -->
</body>
<!-- Termina el body -->

 ?>
