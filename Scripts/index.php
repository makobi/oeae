<!-- 
Christian A. Rodriguez Encarnacion
Este script es el home page para hacer login. Te va a mandar a
profile.php si los credenciales son validos, sino te vas a quedar aqui
 -->

<?php session_start(); ?>

<html>
<head>
	<title>Login Page</title>
</head>
<body>
	<h1>Sign In</h1> <br>
	<form method='post' action='no-index.php'>
		Email:
		<input type='text' name='email'> <br>
		Password:
		<input type='password' name='passwd'> <br>
		<input type='submit' value='Login!'>
	</form>
</body>
</html>