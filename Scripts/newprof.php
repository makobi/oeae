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
$dirtypass = generateRandomPassword();
$profpass = md5($dirtypass);

// Insert Profesor data to the Database
if (mysql_query("INSERT INTO Profesores (nombre_prof, email, passwd, dpto_prof, fac_prof) values ('$profname', '$profemail', '$profpass', '$profdept', '$proffaculty')")) {

  // Send an email to the professor using Sendgrid
  $url = 'http://sendgrid.com/';
  $user = 'chrisrodz';
  $pass = 'emmyNoether';

  $params = array(
      'api_user'  => $user,
      'api_key'   => $pass,
      'to'        => $profemail,
      'subject'   => 'Sistema de Evaluacion Estudiantil',
      'html'      => 'Saludos: Su password para el nuevo sistema estudiantil es '.$dirtypass.'. Puede acceder a su cuenta entrando a ada.uprrp.edu/~chrodriguez/oeae/Front-end.',
      'text'      => 'Saludos: Su password para el nuevo sistema estudiantil es '.$dirtypass.'. Puede acceder a su cuenta entrando a ada.uprrp.edu/~chrodriguez/oeae/Front-end.',
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

  echo "An email has been sent to the new professor";

} else {
 echo "Professor could not be created, please contact the system administrator.";
}



 ?>