<?php 

return [
	'tradename' => [
		'type' => 'string',
		'required' => true,
		'maxLength' => 64
	],
	'business_name' => [
			'type' => 'string',
			'required' => true,
			'maxLength' => 64
	],
	'cif' => [
			'type' => 'string',
			'required' => true,
			'maxLength' => 32
	],
	'id_status' => [
			'type' => 'int',
			'required' => true
	]
];

?>