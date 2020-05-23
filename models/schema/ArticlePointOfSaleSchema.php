<?php 
return [
	'name' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 128,
		'nameError' => 'nombre'
	],
	'serial' => [
		'type' => 'string',
		'maxLength' => 32,
		'nameError' => 'número de serie'
	],
	'barcode' => [
		'type' => 'string',
		'maxLength' => 32,
		'nameError' => 'código de barras'
	],
	'code' => [
		'type' => 'string',
		'maxLength' => 64,
		'nameError' => 'código'
	],
	'id_type' => [
		'type' => 'int',
		'required' => true,
		'nameError' => 'tipo'
	],
	'observations' => [
		'type' => 'string',
		'maxLength' => 1024,
		'nameError' => 'observaciones'
	]
];
?>