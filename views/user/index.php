<?php

// botón filtro de buscador.
$linksFilter = [
  'Rol' => [
    ['name' => 'Administradores', 'filter' => 'users._id_rol', 'to' => '1'],
    ['name' => 'Operarios', 'filter' => 'users._id_rol', 'to' => '2'],
  ],
  'Estado' => [
    ['name' => 'Activos', 'filter' => 'users._id_status', 'to' => '1'],
    ['name' => 'Bloqueados', 'filter' => 'users._id_status', 'to' => '2']
  ]
];

include 'views/includes/viewTable.php';
