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

</head>
<!-- Termina el head -->

<!-- Comienza el body -->
<body>
	<!-- Esto es la barra de arriba, que tiene el log-out -->
	<div id="top_bar">
		
		<a href="" id="logout"><p>Logout</p></a>
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
					<?php 
						while ($row=mysql_fetch_array($cursos)) {
							echo "
							<a href='no-index.html' ><div class='secction'> 
								<div ><img src='class_img.jpg' id='effect'></div>
								<p>".$row[0]." ".$row[1]."</p>
							</div></a>";
						}
					?>
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
					<table>
						<tr>
							<td>
					<ul class="thumbnails">
					  <li >
					    <a href="#" class="thumbnail">
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://renewable.uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Rubrics</h3>
					     </a>
					  </li>
					   <li >
					    <a href="#" class="thumbnail">
					    	<img src="http://api.webthumbnail.org?width=275&height=175&screen=1280&format=png&url=http://uprrp.edu" alt="Captured by webthumbnail.org" />
							<h3>Graphs</h3>
					     </a>
					  </li>

					  <li >
					    <a href="#" class="thumbnail">
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