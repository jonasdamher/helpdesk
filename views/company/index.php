<?php

// botón filtro de buscador.
$linksFilter = [
  'Estado' => [
    ['name' => 'Activos', 'filter' => 'companies._id_status', 'to' => '1'],
    ['name' => 'Inactivos', 'filter' => 'companies._id_status', 'to' => '2']
  ]
];

include 'views/includes/viewTable.php';
