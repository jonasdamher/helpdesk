 <div class="container container-dashboard f-column">
   <section class="dashboard-header bg-blue">
     <?php
      $url = 'details';
      $nameSection = 'Artículos recogidos';
      include 'views/includes/header-action.php';
      ?>
   </section>
   <section class="bg-white dashboard-content shadow-sm">
     <div class="d-flex j-between f-items-end pd-b-1">
       <div class="d-flex f-items-end w-100-sm">
         <button id="btn-open-modal-new" class="btn btn-dark border-rd shadow-lg" type="button"><span><i class="fas fa-plus"></i></span>Artículo recogido</button>
       </div>
     </div>
     <div id="table-details" class="<?= !empty($articlePointOfSale) ? '' : 'd-none' ?>">
       <div class="table-responsive">
         <table class="table">
           <thead>
             <tr>
               <?php
                $thead = [
                  ['name' => 'Nombre'],
                  ['name' => 'Nº de serie'],
                  ['name' => 'Código de barras'],
                  ['name' => 'tipo']
                ];
                include 'views/includes/thead-order.php'; ?>
             </tr>
           </thead>
           <tbody>
             <?php foreach ($articlePointOfSale as $article) { ?>
               <tr data-id="<?= $article['_id'] ?>">
                 <td>
                   <p class="p text-bold"><?= $article['name'] ?></p>
                   <p><?= (is_null($article['observations'])) ? '' : mb_substr($article['observations'], 0, 50) . '...'; ?></p>
                 </td>
                 <td><?= is_null($article['serial']) ? 'Ninguno' : $article['serial'] ?></td>
                 <td><?= is_null($article['barcode']) ? 'Ninguno' : $article['barcode'] ?></td>
                 <td><?= $article['type'] ?></td>
                 <td>
                   <?php
                    $linkTable = [
                      'title' =>  'artículo ' . $article['name'] . ' ' . $article['serial'],
                      'links' => [
                        [
                          'name' => 'Editar',
                          'type' =>  'update',
                          'icon' => 'pen'
                        ], [
                          'name' => 'Eliminar',
                          'type' =>  'delete',
                          'icon' => 'trash'
                        ]
                      ]
                    ];
                    include 'views/includes/dropdown-table-modal.php';
                    ?>
                 </td>
               </tr>
             <?php } ?>
           </tbody>
           <tfoot>
             <tr>
               <td colspan="5">
                 <div class="d-flex j-content-end">
                   <?php include 'views/includes/pagination.php'; ?>
                 </div>
               </td>
             </tr>
           </tfoot>
         </table>
       </div>
     </div>
   </section>
   <?php include 'views/includes/snackbar-modal.php'; ?>
 </div>

 <!-- MODAL NEW ARTICLE POINT OF SALE -->
 <div id="modal-new" class="modal d-none">
   <div class="modal-content">
     <div class="card-modal shadow-sm bg-white">
       <div class="card-body">
         <div class="d-flex j-between f-items-center pd-b-2">
           <p class="text-bold">Nuevo artículo recogido</p>
           <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
         </div>
         <form class="form articlePto-new">
           <div class="form-box-input">
             <label class="label" for="name">Nombre de artículo</label>
             <input class="ipt ipt-default" id="name" name="name" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="barcode">Código de barras</label>
             <input class="ipt ipt-default" id="barcode" name="barcode" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="serial">Nº de serie</label>
             <input class="ipt ipt-default" id="serial" name="serial" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="code">Código de empresa</label>
             <input class="ipt ipt-default" id="code" name="code" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="observations">Observaciones</label>
             <textarea class="ipt ipt-default" id="observations" name="observations" type="text" autocomplete="off" rows="3"></textarea>
           </div>
           <div class="form-box-input">
             <label for="id_type">Tipo de artículo</label>
             <div class="select">
               <select class="ipt ipt-default" id="id_type" name="id_type">
                 <?php foreach ($typesArticle as $value) { ?>
                   <option value="<?= $value['_id'] ?>"><?= $value['type'] ?></option>
                 <?php } ?>
               </select>
             </div>
           </div>
           <input id="id_pto" name="id_pto" type="hidden" value="<?= $incidence['_id_pto_of_sales'] ?>" />
           <input id="id_incidence" name="id_incidence" type="hidden" value="<?= $_GET['id'] ?>" />
           <button class="btn btn-dark border-rd shadow-lg" type="submit">Guardar</button>
         </form>
         <div class="text-error text-bold text-red d-flex  f-column f-items-center"></div>
       </div>
     </div>
   </div>
 </div>
 <!-- MODAL UPDATE ARTICLE POINT OF SALE -->
 <div id="modal-update" class="modal d-none">
   <div class="modal-content">
     <div class="card-modal shadow-sm bg-white">
       <div class="card-body">
         <div class="d-flex j-between f-items-center pd-b-2">
           <p class="text-bold">Actualizar artículo recogido</p>
           <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
         </div>
         <form class="form articlePto-update" data-url="controller=ArticlePointOfSale&action=read">
           <div class="form-box-input">
             <label class="label" for="name_update">Nombre de artículo</label>
             <input class="ipt ipt-default" id="name_update" name="name" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="barcode_update">Código de barras</label>
             <input class="ipt ipt-default" id="barcode_update" name="barcode" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="serial_update">Nº de serie</label>
             <input class="ipt ipt-default" id="serial_update" name="serial" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="code_update">Código de empresa</label>
             <input class="ipt ipt-default" id="code_update" name="code" type="text" autocomplete="off" />
           </div>
           <div class="form-box-input">
             <label class="label" for="observations_update">Observaciones</label>
             <textarea class="ipt ipt-default" id="observations_update" name="observations" type="text" autocomplete="off" rows="3"></textarea>
           </div>
           <div class="form-box-input">
             <label for="id_type_update">Tipo de artículo</label>
             <div class="select">
               <select class="ipt ipt-default" id="id_type_update" name="id_type">
                 <?php foreach ($typesArticle as $value) { ?>
                   <option value="<?= $value['_id'] ?>"><?= $value['type'] ?></option>
                 <?php } ?>
               </select>
             </div>
           </div>
           <input id="id_update" name="id" type="hidden" autocomplete="off" />
           <button class="btn btn-dark border-rd shadow-lg" type="submit">Guardar</button>
         </form>
         <div class="text-error-update text-bold text-red d-flex  f-column f-items-center"></div>
       </div>
     </div>
   </div>
 </div>
 <!-- MODAL DELETE CONTACT -->
 <div id="modal-delete" class="modal d-none">
   <div class="modal-content">
     <div class="card-modal shadow-sm bg-white">
       <div class="card-body d-flex f-column j-content-center">
         <div class="d-flex j-between f-items-center pd-b-2">
           <p class="text-bold">Eliminar artículo recogido</p>
           <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
         </div>
         <p class="pd-b-2">¿Seguro que quieres eliminar el artículo recogido <span class="text-bold text-ref-delete"></span> de la lista?</p>
         <button data-id="" class="btn btn-delete btn-articlePto-delete btn-red border-rd shadow-lg" type="button">Si, quiero eliminar el artículo</button>
         <div class="text-error-delete text-bold text-red d-flex f-column f-items-center"></div>
       </div>
     </div>
   </div>
 </div>