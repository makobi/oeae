<?php 
/*
Christian A. Rodriguez Encarnacion
Este script crea al profesor nuevo en la base de datos usando los credenciales
de prof.php. Queda mandar un email al profesor para que entre a su cuenta nueva
y, si desesa, cambiar su contraseña por otra. Esto lo voy a hacer con Sendgrid.
*/



// Function to generate random Password, taken from Stack Overflow
function generateRandomPassword() {
  //Initialize the random password
  $password = '';

  //Initialize a random desired length
  $desired_length = rand(8, 12);

  for($length = 0; $length < $desired_length; $length++) {
    //Append a random ASCII character (including symbols)
    $password .= chr(rand(32, 126));
  }

  return $password;
}

// Connect to the Database
$db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// Choose the database 'Avaluo'
if ($db) {
  mysql_select_db("Avaluo");
} else {
  echo "no salio";
  exit();
}

//  Get professors credentials from the html form, and generate a random password
$profemail = $_GET['profemail'];
$profname = $_GET['profname'];
$profdept = $_GET['profdept'];
$proffaculty = $_GET['proffaculty'];
$profpass = generateRandomPassword();
echo $profpass;
$profpass = md5($profpass);

// Insert Profesor data to the Database
if (mysql_query("INSERT INTO Profesores (nombre_prof, email, passwd, dpto_prof, fac_prof) values ('$profname', '$profemail', '$profpass', '$profdept', '$proffaculty')")) {
  //echo "Salio el query";
 // $email = new HttpRequest('https://sendgrid.com/api/mail.send.json?api_user=christian.rodriguez35@upr.edu&api_key=emmyNoether&to=christian.etpr10@gmail.com&toname=Christian&subject=New Profesor&text=SeCreoUnProfNew&from=christian.rodriguez35@upr.edu', HttpRequest::METH_GET);
 // $email->send();
} else {
 // echo "No salio el query";
}



 ?>