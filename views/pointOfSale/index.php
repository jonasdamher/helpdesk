<div class="container container-dashboard f-column">

  <section class="dashboard-header bg-blue">
    <?php
    $title = 'Puntos de venta';
    $buttonName = 'Añadir';
    include 'views/includes/header-button-dash.php';
    ?>
  </section>
  <?php if ($pointsOfSales['valid']) { ?>
    <section class="bg-white dashboard-content shadow-sm">

      <div class="d-flex j-between f-items-end pd-b-1">

        <div class="d-flex f-items-end w-100-sm">
          <?php include 'views/includes/search.php'; ?>
          <?php
          $linksFilter = [
            'Estado' => [
              ['name' => 'Activos', 'filter' => 'points_of_sales._id_status', 'to' => '1'],
              ['name' => 'Inactivos', 'filter' => 'points_of_sales._id_status', 'to' => '2']
            ]
          ];
          include 'views/includes/dropdown-filter.php';
          ?>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <?php
              $thead = [
                ['name' => 'Nombre de punto de venta', 'order' => 'points_of_sales.name', 'alt' => 'ASC'],
                ['name' => 'Código de PTO'],
                ['name' => 'Razón social', 'order' => 'companies.business_name', 'alt' => 'ASC'],
                ['name' => 'CIF/NIF'],
                ['name' => 'Estado', 'order' => 'pto_status.status', 'alt' => 'ASC'],
                ['name' => 'Creado', 'order' => 'points_of_sales.created', 'alt' => 'DESC', 'title' => 'fecha']
              ];
              include 'views/includes/thead-order.php';
              ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pointsOfSales['result'] as $point) { ?>
              <tr>
                <td><?= $point['name'] ?></td>
                <td><?= $point['company_code'] ?></td>
                <td><a class="link text-blue" tabindex="-1" href="<?= URL_BASE . 'company/update/' . $point['_id_company']; ?>"><?= $point['business_name'] ?></a></td>
                <td><?= $point['cif'] ?></td>
                <td class="text-bold text-<?= ($point['_id_status'] == 1) ? 'green' : 'red'; ?>">
                  <?= $point['status']; ?>
                </td>
                <td>
                  <div class="w-max">
                    <?= date_format(date_create($point['created']), 'd-m-Y'); ?>
                  </div>
                </td>
                <td>
                  <?php
                  $linkTable = [
                    'title' =>  'punto de venta ' . $point['name'],
                    'links' => [
                      [
                        'name' => 'Ver',
                        'url' =>  '/details/' . $point['_id'],
                        'icon' => 'eye'
                      ], [
                        'name' => 'Editar',
                        'url' =>  '/update/' . $point['_id'],
                        'icon' => 'pen'
                      ]
                    ]
                  ];
                  include 'views/includes/dropdown-table.php';
                  ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="d-flex j-content-end pd-t-1">
        <?php include 'views/includes/pagination.php'; ?>
      </div>
    </section>
  <?php } ?>
</div>