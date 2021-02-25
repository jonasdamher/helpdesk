 <div class="container container-dashboard f-column">
   <section class="dashboard-header bg-blue">
     <?php
      $title = 'Empresas';
      $buttonName = 'Añadir';
      include 'views/includes/header-button-dash.php'; ?>
   </section>
   <?php if ($companies['valid']) { ?>
     <section class="bg-white dashboard-content shadow-sm">
       <div class="d-flex j-between f-items-end pd-b-1">
         <div class="d-flex f-items-end w-100-sm">
           <?php
            include 'views/includes/search.php';
            $linksFilter = [
              'Estado' => [
                ['name' => 'Activos', 'filter' => 'companies._id_status', 'to' => '1'],
                ['name' => 'Inactivos', 'filter' => 'companies._id_status', 'to' => '2']
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
                  ['name' => 'Razón social', 'order' => 'companies.business_name', 'alt' => 'ASC'],
                  ['name' => 'Nombre comercial', 'order' => 'companies.tradename', 'alt' => 'ASC'],
                  ['name' => 'CIF/NIF'],
                  ['name' => 'Estado', 'order' => 'comp_status.status', 'alt' => 'ASC'],
                  ['name' => 'Creado', 'order' => 'companies.created', 'alt' => 'DESC', 'title' => 'fecha']
                ];
                include 'views/includes/thead-order.php';
                ?>
             </tr>
           </thead>
           <tbody>
             <?php foreach ($companies['result'] as $company) { ?>
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
                      'title' =>  'empresa ' . $company['business_name'],
                      'links' => [
                        [
                          'name' => 'Editar',
                          'url' => '/update/' . $company['_id'],
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