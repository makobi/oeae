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

?>

<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') : ?>

<?php 

	if (!isset($_GET['email']) || !isset($_GET['tmp'])) {
		header('Location: ../Front-end/index.php');
	}

	$email = $_GET['email'];
	$tmp = $_GET['tmp'];

	$query = mysql_query("SELECT passwd from Profesores where email='$email'");
	$result = mysql_fetch_array($query);

	if($tmp != $result[0]) {
		header('Location: ../Front-end/index.php');
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
	<script type="text/javascript" src="holder.js"></script>

</head>
<!-- Termina el head -->

<!-- Comienza el body -->
<body>
	<!-- Esto es la barra de arriba, que tiene el log-out -->
	<div id="top_bar">
		
		<!-- <a href=""><p id="logout">Logout</p></a> -->
	</div>
	<!-- Termina la barra -->

	<!-- Este wrapper contiene todo lo que esta debajo de la barra -->
	<div id="main_wrapper">

		<!-- Este es el navegador drop down que esta a la izquierda -->
		<div id="nav_drop">
			<!-- Aqui va todo lo que va en la parte izquierda -->
			
				 <p id = "forgotinst"> 
				 Please enter your new password:
				 <p>
					
					<form method='POST' id='rec_email'>
						Password: <br><input type="password" name="password"> <br>
						Confirm Password: <br><input type="password" name="confirm"> <br>
						<input type='hidden' value='<?php echo $email; ?>' name='email'>
						<input type="submit" value="Submit"> 
					</form>
					
					<a href="index.html" > <p id = "recovery">Go Back</p> </a>
			
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

	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];

	if($password != $confirm) {
		header('Location: ../Front-end/index.php');
	}

	$savepass = md5($password);

	mysql_query("UPDATE Profesores set passwd='$savepass' where email='$email'");

	// Credentials for Sendgrid
	  $url = 'http://sendgrid.com/';
	  $user = 'chrisrodz';
	  $pass = 'emmyNoether';	

	  $params = array(
	      'api_user'  => $user,
	      'api_key'   => $pass,
	      'to'        => $email,
	      'subject'   => 'Sistema de Evaluacion Estudiantil',
	      'html'      => 'Saludos: Su nuevo password es '.$password.'. Si usted no solicito este cambio, comuniquese con un administrador.',
	      'text'      => 'Saludos: Su nuevo password es '.$password.'. Si usted no solicito este cambio, comuniquese con un administrador.',
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
