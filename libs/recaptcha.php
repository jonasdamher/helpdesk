<?php 

$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

$recaptcha_secret = $_ENV['SECRET_KEY'];
$recaptcha_response = $_POST['recaptcha_response'];

$urlConnect = $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;
$file_headers = @get_headers($recaptcha_url);

if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
	return false;
}

$recaptcha = file_get_contents($urlConnect);
$recaptcha = json_decode($recaptcha);
return $recaptcha;

?>