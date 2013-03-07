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
	header('Location: http://ada.uprrp.edu/~chrodriguez/index.php');	
	exit();
}

// Save credential in the session variable
$_SESSION['prof_id'] = $credentials['prof_id'];
$_SESSION['nombre_prof'] = $credentials['nombre_prof'];
$_SESSION['email'] = $email;

$query = "SELECT fac_prof, dpto_prof FROM Profesores where prof_id=$_SESSION[prof_id]";
$prof = mysql_fetch_array(mysql_query($query));

$cursosquery = "SELECT nombre_curso, codificacion FROM Profesores NATURAL JOIN ProfesorImparte natural join Cursos where prof_id=$_SESSION[prof_id]"; 
$cursos = mysql_query($cursosquery);

?>

<!doctype html> 
<html lang="en">

<!-- Comienza el head -->
<head>
	<meta charset="utf-8" />
	<title>Tu mai es la gorda</title>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="bootstrap-responsive.css">
	<link rel="stylesheet" href="bootstrap.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="effects.js"></script>
	<script type="text/javascript" src="holder.js"></script>

	 <script type="text/javascript">

	 // Esto explota!
	// <?php 
	// 	while($row=mysql_fetch_array($cursos)) {
	// 		echo "$('#".$row[0]."').click(function() {

	// 			  $('#".$row[1]."').slideToggle('slow', function() {
 //  			});";

	// 	}
	// ?>
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
			<a href="no-index.html" ><div class="secction" id="profile"> 
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
							<li>
								<a href='no-index.html' id='".$row[0]."'>
									<div class='secction'> 
										<div><img src='class_img.jpg' id='effect'></div>
										<p>".$row[0]." ".$row[1]."</p>
									</div>
								</a>
								<ul id='".$row[1]."'>";
							echo $string;
							 $query = "SELECT nombre_act FROM ActividadesCurso natural join Actividades natural join Cursos where nombre_curso='$row[0]'";
							
							 $activity = mysql_query($query);
							
							  if (mysql_num_rows($activity)>0) {
							 	while ($res=mysql_fetch_array($activity)) {
							 		$act = "
									<li>
										<a href='no-index.html'>
											<div class='secction2'>
												<div><img src='class_img.jpg' id='effect'>	</div>
												<p>".$res[0]."</p>
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

				<center>
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

					  <li id="thumb3">
					    <a href="#" class="thumbnail" >
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://ccom.uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Students</h3>
					     </a>
					  </li>
					  
					</ul>
				</td>
				</tr>
				</table>
				</center>

					<div id="content">
						<center>
							<table id="rubrica">

								<?php 
									echo "<tr>
												<td><button type='button' onclick='change_number_rows()'>Edit</button></td>
												<td>1-2</td>
												<td>3-4</td>
												<td>5-6</td>
												<td>7-8</td>
											  </tr>";
								for ($i=0; $i < 5; $i++) { 
										echo "<tr>
												<td><p>Nombre</p>
												</td>
												<td>Descripcion</td>
												<td>Descripcion</td>
												<td>Descripcion</td>
												<td>Descripcion</td>
											  </tr>";
										} ?>
							</table>
						</center>
					</div>
					
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