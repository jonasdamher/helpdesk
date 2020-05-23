<?php 

include 'helpers/expRegular.php';

return [
	'name' => [
		'type' => 'string',
		'required' => true,
		'minLength' => 3,
		'maxLength' => 32
	],
	'phone' => [
		'type' => 'string',
		'maxLength' => 9
	],
	'email' => [
		'type' => 'string',
		'match' => $email,
		'maxLength' => 128
	]
];

?>