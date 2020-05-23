<?php 
return [
	'id_status' => [
		'type' => 'int',
		'required' => true,
		'nameError' => 'estado'
	],
	'serial' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 32,
		'nameError' => 'número de serie'
	],
	'code' => [
		'type' => 'string',
		'maxLength' => 64,
		'nameError' => 'código'
	],
	'observations' => [
		'type' => 'string',
		'maxLength' => 1024,
		'nameError' => 'observaciones'
	]
];
?>