<?php

$url = 'http://sendgrid.com/';
$user = 'chrisrodz';
$pass = 'emmyNoether';

$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'to'        => 'a-leinad93@hotmail.com',
    'subject'   => 'email test',
    'html'      => 'tu mai es la gorda',
    'text'      => 'tu mai es la gorda',
    'from'      => 'christian.etpr10@gmail.com',
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

// print everything out
print_r($response);

?>
