<?php 

include 'helpers/expRegular.php';

return [
	'name' => [
			'type' => 'string',
			'required' => true,
			'minLength' => 3,
			'maxLength' => 32,
			'nameError' => 'nombre'
	],
	'lastname' => [
			'type' => 'string',
			'required' => true,
			'minLength' => 3,
			'maxLength' => 32,
			'nameError' => 'apellidos'
	],
	'email' => [
			'type' => 'string',
			'required' => true,
			'match' => $email,
			'maxLength' => 64
	],
	'currentPassword' => [
			'type' => 'string',
			'required' => true,
			'match' => $password,
			'minLength' => 8,
			'nameError' => 'contraseña actual'
	],
	'password' => [
			'type' => 'string',
			'required' => true,
			'match' => $password,
			'minLength' => 8,
			'nameError' => 'contraseña'
	],
	'id_rol' => [
			'type' => 'int',
			'required' => true,
			'nameError' => 'rol'
	],
	'id_status' => [
			'type' => 'int',
			'required' => true,
			'nameError' => 'estado'
	]
];

?>