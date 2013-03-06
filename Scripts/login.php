<?php session_start(); ?>

<html>
<head>
	<title>Login Page</title>
</head>
<body>
	<h1>Sign In</h1> <br>
	<form method='post' action='profile.php'>
		Email:
		<input type='text' name='email'> <br>
		Password:
		<input type='password' name='passwd'> <br>
		<input type='submit' value='Login!'>
	</form>
</body>
</html>