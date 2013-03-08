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

// Credencials for profesor login
$email = $_POST['email'];
$passwd = md5($_POST['passwd']);

// Query to check for credentials
$loginquery = "SELECT passwd, prof_id, nombre_prof FROM Profesores where email='$email'";
$credentials = mysql_fetch_array(mysql_query($loginquery));

// If credential are not valid, send back to login page
if ($credentials['passwd'] !== $passwd) {
	header('Location: http://ada.uprrp.edu/~chrodriguez/oeae/Front-end/');	
	exit();
}

// Save credential in the session variable
$_SESSION['prof_id'] = $credentials['prof_id'];
$_SESSION['nombre_prof'] = $credentials['nombre_prof'];
$_SESSION['email'] = $email;


// Aqui se hacen los queries para sacar toda la info del profesor

// Informacion de la facultad y el departamento
$profinfo = "SELECT fac_prof, dpto_prof FROM Profesores where prof_id=$_SESSION[prof_id]";
$prof = mysql_fetch_array(mysql_query($profinfo));
$_SESSION['fac_prof'] = $prof['fac_prof'];
$_SESSION['dpto_prof'] = $prof['dpto_prof'];

// Informacion sobre los cursos que esta dando el profesor
$cursosquery = "SELECT nombre_curso, codificacion FROM Profesores NATURAL JOIN ProfesorImparte natural join Cursos where prof_id=$_SESSION[prof_id]"; 
$cursos = mysql_query($cursosquery);

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


</head>
<!-- Termina el head -->

<!-- Comienza el body -->
<body>
	<!-- Esto es la barra de arriba, que tiene el log-out -->
	<div id="top_bar">
		
		<a href="index.html" id="logout"><p>Logout</p></a>
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
				<div class="title"> <p>Classes</p></div>
				<div class="secction1"> 
					<ul>
					<?php
						while ($row=mysql_fetch_array($cursos)) {
							$string = "
							<li class='cursos'>
								<a href='#' id='".$row[0]."'>
									<div class='secction'> 
										<div id='mierda'><img src='class_img.jpg' id='effect'>
											<p>".$row[0]." ".$row[1]."</p>
											<a href='#''><img class='add' src='add.png' width='10' height='10'></a>
										</div>
									</div>
								</a>
								<ul id='".$row[1]."'>";
							echo $string;
							 $query = "SELECT nombre_act, act_id FROM ActividadesCurso natural join Actividades natural join Cursos where nombre_curso='$row[0]'";
							
							 $activity = mysql_query($query);
							
							  if (mysql_num_rows($activity)>0) {
							 	while ($res=mysql_fetch_array($activity)) {
							 		$act = "
									<li>
										<a href='#' class='actividades'>
											<div class='secction2'>
												<div><img src='class_img.jpg' id='effect'>	</div>
												<p id='".$res[1]."'>".$res[0]."</p>
											</div>
										</a>
									</li>";
									echo $act;
								}
							}
							echo "</li>";						

						}	
						?>
					</ul>
				</div>
				<div class="title"> <p>Options</p></div>
				<div class="secction1"> 
					<a href="no-index.html" ><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Option Name Here</p>
					</div></a>
					<a href="no-index.html" ><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Option Name Here</p>
					</div></a>
					<a href="no-index.html" ><div class="secction"> 
						<div ><img src="option_icon.png" id="effect"></div>
						<p>Option Name Here</p>
					</div></a>
					<a href="no-index.html" ><div class="secction"> 
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
						<h2> <?php echo "$_SESSION[fac_prof]"; ?></h2>
						<h2> <?php echo "$_SESSION[dpto_prof]"; ?></h2> <br>

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