<?php
// botón filtro de buscador.
$linksFilter = [
  'Estado' => [
    ['name' => 'Activos', 'filter' => 'points_of_sales._id_status', 'to' => '1'],
    ['name' => 'Inactivos', 'filter' => 'points_of_sales._id_status', 'to' => '2']
  ]
];

include 'views/includes/viewTable.php';
