<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') : ?>
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
	<script type="text/javascript" src="holder.js"></script>

</head>
<!-- Termina el head -->

<!-- Comienza el body -->
<body>
	<!-- Esto es la barra de arriba, que tiene el log-out -->
	<div id="top_bar">
		<img src="OEAE.png" style="width:100px; padding-left:10px;">
		<!-- <a href=""><p id="logout">Logout</p></a> -->
	</div>
	<!-- Termina la barra -->

	<!-- Este wrapper contiene todo lo que esta debajo de la barra -->
	<div id="main_wrapper">

		<!-- Este es el navegador drop down que esta a la izquierda -->
		<div id="nav_drop">
			<!-- Aqui va todo lo que va en la parte izquierda -->
			
				 <p id = "forgotinst"> 
				 If you want to change your password, please provide us with your email address,
				 an email with instructions on changing your password will be sent to you.
				 <p>
					
					<form method='POST' id='rec_email'>
						Email: <br><input type="text" name="email"> <br>
						<input type="submit" value="Submit"> 
					</form>
					
					<a href="index.php" > <p id = "recovery">Go Back</p> </a>
			
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
			
				<center>
					<h1> OEAE </h1>
					<p id = "placeholder"> 
					Welcome to the OEAE Rubric Website <br>
					This website is a work in progress developed by: <br>
					Christian Rodríguez <br>
					Alex Santos <br>
					Tahirí Laboy <br>
					José Reyes
					</p>
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

<?php else: ?>
<?php 

	// Connect to the Database
	$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");	

	// Choose the database 'Avaluo' 
	if ($db) {
	  mysql_select_db("Avaluo");
	} else {
	  echo "no salio";
	  exit();
	}

	$email = $_POST['email'];

	$query = mysql_query("SELECT * from Profesores where email='$email'")

?>

	<?php if(mysql_num_rows($query) < 1) :?>
	<script type="text/javascript">alert("Email not in database. Please contact a system administrator.");</script>
	<?php header('Location: ../Front-end/index.php'); ?>
	<?php endif; ?>
 
<?php 

	$temppass = md5($email);

	mysql_query("UPDATE Profesores set passwd='$temppass' where email='$email'");

	$newlink = 'ada.uprrp.edu/~chrodriguez/oeae/Front-end/newpass.php?tmp='.$temppass.'&email='.$email;

	// Credentials for Sendgrid
	  $url = 'http://sendgrid.com/';
	  $user = 'chrisrodz';
	  $pass = 'emmyNoether';	

	  $params = array(
	      'api_user'  => $user,
	      'api_key'   => $pass,
	      'to'        => $email,
	      'subject'   => 'Sistema de Evaluacion Estudiantil',
	      'html'      => 'Saludos: Para cambiar su password acceda al siguiente link: <a href="'.$newlink.'">'.$newlink.'</a>',
	      'text'      => 'Saludos: Para cambiar su password acceda al siguiente link: '.$newlink,
	      'from'      => 'oeae.uprrp@upr.edu',
	    );  
	  	

	  $request =  $url.'api/mail.send.json';  	

	  // Generate curl request
	  $session = curl_init($request);
	  // Tell curl to use HTTP POST
	  curl_setopt ($session, CURLOPT_POST, true);
	  // Tell curl that this is the body of the POST
	  curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
	  // Tell curl not to return headers, but do return the response
	  curl_setopt($session, CURLOPT_HEADER, false);
	  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  	

	  // obtain response
	  $response = curl_exec($session);
	  curl_close($session);

 ?>

<?php header('Location: ../Front-end/index.php'); ?>

<?php endif; ?>
