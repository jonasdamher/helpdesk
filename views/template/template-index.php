<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <div class="dashboard-header bg-blue">
    <?php 
    $title = 'Incidencias';
    $buttonName = 'Nueva incidencia';
    include 'views/partials/header-button-dash.php'; ?>
    </div>
    <div class="bg-white dashboard-content shadow-sm">
      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex f-items-end w-100-sm">
          <?php
          include 'views/partials/search.php';
          ?>
        </div>
      </div>
      <div class="table-responsive m-b-1">
        <table class="table">
          <thead>
            <tr>
              <?php 
              $thead = [
                ['name' => 'Incidencia','order' => 'incidences.subject', 'alt' => 'ASC'],
                ['name' => 'Punto de venta','order' => 'points_of_sales.name', 'alt' => 'ASC'],
                ['name' => 'Prioridad','order' => 'inc_priorities.priority', 'alt' => 'ASC'],
                ['name' => 'Estado','order' => 'inc_status.status', 'alt' => 'ASC'],
                ['name' => 'Atendida','order' => 'users.lastname', 'alt' => 'ASC'],
                ['name' => 'Creado','order' => 'incidences.created', 'alt' => 'DESC']
              ];
              include 'views/partials/thead-order.php'; ?>
            </tr>
          </thead>
          <tbody>
           <?php foreach ($incidences as $incidence) { ?>
              <tr>
                <td>
                  <p class="p text-bold"><?= $incidence['subject'] ?></p>
                  <p><?= mb_substr($incidence['description'], 0, 50).'...'; ?></p>
                </td>
                <td><a href="<?= url_base.'pointOfSale/details/'.$incidence['_id_pto_of_sales'] ?>"><?= $incidence['point_of_sale'].' '.$incidence['company_code'] ?></a></td>
                <td><?= $incidence['priority'] ?></td>
                <td><?= $incidence['status'] ?></td>
                <td><?= $incidence['name'].' '.$incidence['lastname'] ?></td>
                <td>
                  <div class="w-max">  
                    <?= date_format(date_create($incidence['created']), 'd-m-Y'); ?>
                  </div>
                </td>
                <td>
                  <?php 
                  $linkTable = [
                    'title' =>  'incidencia '.$incidence['subject'],
                    'links' => [
                      [
                        'name' => 'Ver',
                        'url' =>  '/details/'.$incidence['_id'], 
                        'icon' => 'eye'
                      ],[
                        'name' => 'Editar',
                        'url' =>  '/update/'.$incidence['_id'], 
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
        </table>
      </div>
      <div class="d-flex j-content-end">
        <?php include 'views/partials/pagination.php'; ?>
      </div>
    </div>
  </div>
</main>
<?php include 'views/partials/footer.php'; ?>