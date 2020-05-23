<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php 
      $title = 'Incidencias';
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
                ['name' => 'Incidencia','order' => 'incidences.subject', 'alt' => 'ASC', 'title' => 'asunto'],
                ['name' => 'Punto de venta','order' => 'points_of_sales.name', 'alt' => 'ASC'],
                ['name' => 'Prioridad','order' => 'inc_priorities.priority', 'alt' => 'ASC'],
                ['name' => 'Estado','order' => 'inc_status.status', 'alt' => 'ASC'],
                ['name' => 'Atendida'],
                ['name' => 'Creado','order' => 'incidences.created', 'alt' => 'DESC', 'title' => 'fecha']
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
                <td><a class="link text-blue" href="<?= url_base.'pointOfSale/details/'.$incidence['_id_pto_of_sales'] ?>"><?= $incidence['point_of_sale'].' '.$incidence['company_code'] ?></a></td>
                <td class="text-bold text-<?= $incidence['_id_priority'] == 1 ? ('green') : ($incidence['_id_priority'] == 3 ? ('orange') : ($incidence['_id_priority'] == 4 ? ('red') : ($incidence['_id_priority'] == 5 ? ('blue') : ''))) ?>">
                 <?= $incidence['priority'] ?>
                 </td>
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