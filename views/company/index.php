<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php 
        $title = 'Empresas';
        $buttonName = 'Añadir';
        include 'views/partials/header-button-dash.php'; ?>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex f-items-end w-100-sm">
          <?php
          include 'views/partials/search.php';
          $linksFilter = [
            'Estado' => [ 
              ['name' => 'Activos','filter' => 'companies._id_status', 'to' => '1'],
              ['name' => 'Inactivos','filter' => 'companies._id_status', 'to' => '2']
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
                ['name' => 'Razón social','order' => 'companies.business_name', 'alt' => 'ASC'],
                ['name' => 'Nombre comercial','order' => 'companies.tradename', 'alt' => 'ASC'],
                ['name' => 'CIF/NIF'],
                ['name' => 'Estado','order' => 'comp_status.status', 'alt' => 'ASC'],
                ['name' => 'Creado','order' => 'companies.created', 'alt' => 'DESC', 'title' => 'fecha']
              ];
              include 'views/partials/thead-order.php'; 
            ?>
            </tr>
          </thead>
          <tbody>
           <?php foreach ($companies as $company) { ?>
              <tr>
                <td><?= $company['business_name'] ?></td>
                <td><?= $company['tradename'] ?></td>
                <td><?= $company['cif'] ?></td>
                <td class="text-bold text-<?= ($company['_id_status'] == 1) ? 'green' : 'red'; ?>">
                  <?= $company['status']; ?>
                </td>
                <td>
                <div class="w-max">  
                  <?= date_format(date_create($company['created']), 'd-m-Y'); ?>
                </div>
                </td>
                <td>
                <?php 
                $linkTable = [
                  'title' =>  'empresa '.$company['business_name'],
                  'links' => [
                    [
                      'name' => 'Editar',
                      'url' => '/update/'.$company['_id'], 
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
              <td colspan="6">
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