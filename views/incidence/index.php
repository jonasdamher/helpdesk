 <div class="container container-dashboard f-column">
   <section class="dashboard-header bg-blue">
     <?php
      $title = 'Incidencias';
      $buttonName = 'Añadir';
      include 'views/includes/header-button-dash.php'; ?>
   </section>
   <?php if ($incidences['valid']) { ?>
     <section class="bg-white dashboard-content shadow-sm">
       <div class="d-flex j-between f-items-end pd-b-1">
         <div class="d-flex f-items-end w-100-sm">
           <?php
            include 'views/includes/search.php';
            ?>
         </div>
       </div>
       <div class="table-responsive">
         <table class="table">
           <thead>
             <tr>
               <?php
                $thead = [
                  ['name' => 'Incidencia', 'order' => 'incidences.subject', 'alt' => 'ASC', 'title' => 'asunto'],
                  ['name' => 'Punto de venta', 'order' => 'points_of_sales.name', 'alt' => 'ASC'],
                  ['name' => 'Prioridad', 'order' => 'inc_priorities.priority', 'alt' => 'ASC'],
                  ['name' => 'Estado', 'order' => 'inc_status.status', 'alt' => 'ASC'],
                  ['name' => 'Atendida'],
                  ['name' => 'Creado', 'order' => 'incidences.created', 'alt' => 'DESC', 'title' => 'fecha']
                ];
                include 'views/includes/thead-order.php'; ?>
             </tr>
           </thead>
           <tbody>
             <?php foreach ($incidences['result'] as $incidence) { ?>
               <tr>
                 <td>
                   <p class="p text-bold"><?= $incidence['subject'] ?></p>
                   <p><?= mb_substr($incidence['description'], 0, 50) . '...'; ?></p>
                 </td>
                 <td><a class="link text-blue" href="<?= URL_BASE . 'pointOfSale/details/' . $incidence['_id_pto_of_sales'] ?>"><?= $incidence['point_of_sale'] . ' ' . $incidence['company_code'] ?></a></td>
                 <td class="text-bold text-<?= $incidence['_id_priority'] == 1 ? ('green') : ($incidence['_id_priority'] == 3 ? ('orange') : ($incidence['_id_priority'] == 4 ? ('red') : ($incidence['_id_priority'] == 5 ? ('blue') : ''))) ?>">
                   <?= $incidence['priority'] ?>
                 </td>
                 <td><?= $incidence['status'] ?></td>
                 <td><?= $incidence['name'] . ' ' . $incidence['lastname'] ?></td>
                 <td>
                   <div class="w-max">
                     <?= date_format(date_create($incidence['created']), 'd-m-Y'); ?>
                   </div>
                 </td>
                 <td>
                   <?php
                    $linkTable = [
                      'title' =>  'incidencia ' . $incidence['subject'],
                      'links' => [
                        [
                          'name' => 'Ver',
                          'url' =>  '/details/' . $incidence['_id'],
                          'icon' => 'eye'
                        ], [
                          'name' => 'Editar',
                          'url' =>  '/update/' . $incidence['_id'],
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