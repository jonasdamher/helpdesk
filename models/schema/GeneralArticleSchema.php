<?php
return [
	'name' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 128
	],
	'description' => [
		'type' => 'string',
		'maxLength' => 1024
	],
	'barcode' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 24
	],
	'cost' => [
		'type' => 'float'
	],
	'pvp' => [
		'type' => 'float'
	],
	'id_provider' => [
		'type' => 'int',
		'required' => true
	],
	'id_type' => [
		'type' => 'int',
		'required' => true
	]
];
?>