<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php 
      $title = 'Proveedores';
      $buttonName = 'Añadir';
      include 'views/partials/header-button-dash.php'; ?>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex f-items-end w-100-sm">
          <?php
          include 'views/partials/search.php';
          ?>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <?php 
              $thead = [
                ['name' => 'Razón social','order' => 'business_name', 'alt' => 'ASC'],
                ['name' => 'Nombre comercial','order' => 'tradename', 'alt' => 'ASC'],
                ['name' => 'CIF/NIF'],
                ['name' => 'Email'],
                ['name' => 'Teléfono'],
                ['name' => 'Creado','order' => 'created', 'alt' => 'DESC', 'title' => 'fecha']
              ];
              include 'views/partials/thead-order.php'; ?>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($suppliers as $supplier) { ?>
              <tr>
                <td><?= $supplier['business_name'] ?></td>
                <td><?= $supplier['tradename'] ?></td>
                <td><?= $supplier['cif'] ?></td>
                <td><?= $supplier['email'] ?></td>
                <td><?= $supplier['phone'] ?></td>
                <td>
                  <div class="w-max">
                    <?= date_format(date_create($supplier['created']), 'd-m-Y'); ?>
                  </div>
                </td>
                <td>
                <?php 
                $linkTable = [
                  'title' =>  'proveedor '.$supplier['business_name'],
                  'links' => [
                    [
                      'name' => 'Editar',
                      'url' =>  '/update/'.$supplier['_id'], 
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