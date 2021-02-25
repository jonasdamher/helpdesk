 <div class="container container-dashboard f-column">
   <div class="dashboard-header bg-blue">
     <?php
      $title = 'Artículos';
      $buttonName = 'Añadir';
      include 'views/includes/header-button-dash.php'; ?>
   </div>
   <?php if ($articles['valid']) { ?>
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
                  ['name' => 'Nombre', 'order' => 'articles.name', 'alt' => 'ASC'],
                  ['name' => 'Código de barras'],
                  ['name' => 'Proveedor', 'order' => 'suppliers.business_name', 'alt' => 'ASC'],
                  ['name' => 'Unidades'],
                  ['name' => 'Creado', 'order' => 'articles.created', 'alt' => 'DESC', 'title' => 'fecha']
                ];
                include 'views/includes/thead-order.php'; ?>
             </tr>
           </thead>
           <tbody>
             <?php foreach ($articles['result'] as $article) { ?>
               <tr>
                 <td class="td-image">
                   <?php
                    $dirImage = 'articles/' . $article['image'];
                    $titleImage = $article['name'];
                    $icon = 'box';
                    include 'views/includes/image-64px.php';
                    ?>
                   <div class="pd-l-1">
                     <p class="p"><?= $article['name']; ?>
                     <p>
                     <p class="text-bold text-gray"><?= $article['type']; ?>
                     <p>
                   </div>
                 </td>
                 <td><?= $article['barcode']; ?></td>
                 <td><a class="link text-blue" tabindex="-1" href="<?= URL_BASE . 'supplier/update/' . $article['_id_provider']; ?>"><?= $article['business_name'] ?></a></td>
                 <td class="text-bold"><?= ($article['units'] == 0) ? 'Ninguna' : $article['units'] ?></td>
                 <td>
                   <div class="w-max">
                     <?= date_format(date_create($article['created']), 'd-m-Y'); ?>
                   </div>
                 </td>
                 <td>
                   <?php
                    $linkTable = [
                      'title' =>  'proveedor ' . $article['name'],
                      'links' => [
                        [
                          'name' => 'Ver',
                          'url' =>  '/details/' . $article['_id'],
                          'icon' => 'eye'
                        ], [
                          'name' => 'Editar',
                          'url' =>  '/update/' . $article['_id'],
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