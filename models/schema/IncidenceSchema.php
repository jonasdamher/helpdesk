<?php 

return [
	'subject' => [
			'type' => 'string',
			'required' => true,
			'maxLength' => 128
	],
	'description' => [
			'type' => 'string',
			'maxLength' => 1024
	],
	'id_pto_of_sales' => [
			'type' => 'int',
			'required' => true,
	],
	'id_attended' => [
			'type' => 'int',
			'required' => true
	],
	'id_priority' => [
			'type' => 'int',
			'required' => true
	],
	'id_status' => [
			'type' => 'int',
			'required' => true
	],
	'id_type' => [
			'type' => 'int',
			'required' => true
	]
];

?>