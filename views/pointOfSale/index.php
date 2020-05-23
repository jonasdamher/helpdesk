<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    
    <section class="dashboard-header bg-blue">
    <?php 
      $title = 'Puntos de venta';
      $buttonName = 'Añadir';
      include 'views/partials/header-button-dash.php'; 
    ?>
    </section>

    <section class="bg-white dashboard-content shadow-sm">

      <div class="d-flex j-between f-items-end pd-b-1">

        <div class="d-flex f-items-end w-100-sm">
          <?php include 'views/partials/search.php'; ?>
          <?php
          $linksFilter = [
            'Estado' => [
              ['name' => 'Activos','filter' => 'points_of_sales._id_status', 'to' => '1'],
              ['name' => 'Inactivos','filter' => 'points_of_sales._id_status', 'to' => '2']
            ]
          ];
          include 'views/partials/dropdown-filter.php'; 
          ?>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <?php
            $thead = [
              ['name' => 'Nombre de punto de venta','order' => 'points_of_sales.name', 'alt' => 'ASC'],
              ['name' => 'Código de PTO'],
              ['name' => 'Razón social','order' => 'companies.business_name', 'alt' => 'ASC'],
              ['name' => 'CIF/NIF'],
              ['name' => 'Estado','order' => 'pto_status.status', 'alt' => 'ASC'],
              ['name' => 'Creado','order' => 'points_of_sales.created', 'alt' => 'DESC', 'title' => 'fecha']
            ];
            include 'views/partials/thead-order.php'; 
            ?>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($pointsOfSales as $point) { ?>
            <tr>
              <td><?= $point['name'] ?></td>
              <td><?= $point['company_code'] ?></td>
              <td><a class="link text-blue" tabindex="-1" href="<?= url_base.'company/update/'.$point['_id_company'];?>"><?= $point['business_name'] ?></a></td>
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
                'title' =>  'punto de venta '.$point['name'],
                'links' => [
                  [
                    'name' => 'Ver',
                    'url' =>  '/details/'.$point['_id'], 
                    'icon' => 'eye'
                  ], [
                    'name' => 'Editar',
                    'url' =>  '/update/'.$point['_id'], 
                    'icon' => 'pen'
                  ]
                ]
              ];
              include 'views/partials/dropdown-table.php';
              ?>
              </td>
            </tr>
          <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="7">
                <div class="d-flex j-content-end">
                  <?php include 'views/partials/pagination.php'; ?>
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>

    </section>

  </div>
</main>
<?php include 'views/partials/footer.php'; ?>