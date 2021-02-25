 <div class="container container-dashboard f-column">

   <section class="dashboard-header bg-blue">
     <?php include 'views/includes/header-button-dash.php'; ?>
   </section>
   <?php if ($users['valid']) { ?>
     <section class="bg-white dashboard-content shadow-sm">

       <div class="d-flex j-between f-items-end pd-b-1">

         <div class="d-flex f-items-end w-100-sm">

           <?php include 'views/includes/search.php'; ?>
           <?php
            $linksFilter = [
              'Rol' => [
                ['name' => 'Administradores', 'filter' => 'users._id_rol', 'to' => '1'],
                ['name' => 'Operarios', 'filter' => 'users._id_rol', 'to' => '2'],
              ],
              'Estado' => [
                ['name' => 'Activos', 'filter' => 'users._id_status', 'to' => '1'],
                ['name' => 'Bloqueados', 'filter' => 'users._id_status', 'to' => '2']
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
                  ['name' => 'Usuario', 'order' => 'users.lastname', 'alt' => 'ASC', 'title' => 'apellidos'],
                  ['name' => 'Rol', 'order' => 'users._id_rol', 'alt' => 'ASC'],
                  ['name' => 'Estado', 'order' => 'users._id_status', 'alt' => 'ASC'],
                  ['name' => 'Creado', 'order' => 'users.created', 'alt' => 'DESC', 'title' => 'fecha']
                ];
                include 'views/includes/thead-order.php';
                ?>
             </tr>
           </thead>
           <tbody>
             <?php foreach ($users['result'] as $user) { ?>
               <tr>
                 <td class="td-image">
                   <?php
                    $dirImage = 'users/' . $user['image'];
                    $titleImage = $user['name'] . ' ' . $user['lastname'];
                    $icon = 'user';
                    include 'views/includes/image-64px.php';
                    ?>
                   <div class="pd-l-1">
                     <p class="text-bold p"><?= $user['name'] . ' ' . $user['lastname']; ?></p>
                     <p class="text-gray"><?= $user['email']; ?></p>
                   </div>
                 </td>
                 <td class="text-bold"><?= $user['rol']; ?></td>
                 <td class="text-bold text-<?= ($user['_id_status'] == 1) ? 'green' : 'red'; ?>">
                   <?= $user['status'] ?>
                 </td>
                 <td>
                   <div class="w-max">
                     <?= date_format(date_create($user['created']), 'd-m-Y'); ?>
                   </div>
                 </td>
                 <td>
                   <?php
                    $linkTable = [
                      'title' =>  'usuario ' . $user['name'] . ' ' . $user['lastname'],
                      'links' => [
                        [
                          'name' => 'Editar',
                          'url' => '/update/' . $user['_id'],
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