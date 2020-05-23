<?php 
include 'helpers/expRegular.php';

return [
	'tradename' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 64,
		'nameError' => 'nombre comercial'
	],
	'business_name' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 64,
		'nameError' => 'razón social'
	],
	'cif' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 64,
		'nameError' => 'CIF/NIF'
	],
	'id_country' => [
		'type' => 'int',
		'nameError' => 'país'
	],
	'province' => [
		'type' => 'string',
		'maxLength' => 32,
		'nameError' => 'provincia'
	],
	'locality' => [
		'type' => 'string',
		'maxLength' => 32,
		'nameError' => 'localidad'
	],
	'postal_code' => [
		'type' => 'int',
		'maxLength' => 5,
		'nameError' => 'código postal'
	],
	'address' => [
		'type' => 'string',
		'maxLength' => 64,
		'nameError' => 'dirección'
	],
	'phone' => [
		'type' => 'int',
		'required' => true,
		'maxLength' => 9,
		'nameError' => 'número de teléfono'
	],
	'email' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 64,
		'match' => $email
	]
];

?>