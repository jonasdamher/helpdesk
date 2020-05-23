<?php 

return [
	'id_company' => [
		'type' => 'int',
		'required' => true
	],
	'id_status' => [
			'type' => 'int',
			'required' => true
	],
	'name' => [
			'type' => 'string',
			'required' => true,
			'maxLength' => 32
		],
	'company_code' => [
			'type' => 'string',
			'maxLength' => 32
	],
	'id_country' => [
		'type' => 'int'
	],
	'province' => [
			'type' => 'string',
			'maxLength' => 32
	],
	'locality' => [
			'type' => 'string',
			'maxLength' => 32
	],
	'postal_code' => [
			'type' => 'int',
			'maxLength' => 5
	],
	'address' => [
			'type' => 'string',
			'maxLength' => 64
	]
];

?>