<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    
    <div class="dashboard-header dashboard-tab bg-blue d-flex f-column">
      <?php 
      $url = 'controller';
      $nameSection = 'Ficha de artículo';
      include 'views/partials/header-action.php'; 
      ?>
      <?php include 'views/partials/tab.php'; ?>
    </div>

    <div class="bg-white dashboard-content shadow-sm">
     
      <div class="d-flex j-evenly f-wrap">
        <div class="pd-b-1">
          <?php 
          $dirImage = 'articles/'.$generalArticle['image'];
          $titleImage = $generalArticle['name'];
          $icon = 'box';
          include 'views/partials/image-64px.php';
          ?>
        </div>
        <div class="pd-b-1">
          <p class="p"><?= $generalArticle['name'] ?></p>
          <p class="p"><?= $generalArticle['description'] ?></p>
          <p class="p"><?= $generalArticle['barcode'] ?></p>
          <p class="p"><?= $generalArticle['units'] ?></p>
          <p class="p"><?= $generalArticle['cost'] ?></p>
          <p class="p"><?= $generalArticle['pvp'] ?></p>
          <p class="p"><?= $generalArticle['created'] ?></p>
          <p class="p"><?= $generalArticle['business_name'] ?></p>
          <p class="p"><?= $generalArticle['type'] ?></p>
          <?php if($articlesTotalBorrowed) { ?>
          <p class="p"><?= $articlesTotalBorrowed[0]['status'] ?>: <?= $articlesTotalBorrowed[0]['total'] ?> UDS</p>
          <p class="p"><?= $articlesTotalBorrowed[1]['status'] ?>: <?= $articlesTotalBorrowed[1]['total'] ?> UDS</p>
          <?php } ?>
        </div>
      </div>

      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex f-items-end w-100-sm">
          <button id="btn-open-modal-new" class="btn btn-dark border-rd shadow-lg" type="button"><span><i class="fas fa-plus"></i></span>Añadir artículo</button>
        </div>
      </div>

      <div id="table-details" class="<?= !empty($articles) ? '' : 'd-none' ?>">
        <div class="table-responsive m-b-1">
          <table class="table">
            <thead>
              <tr>
                <?php 
                $thead = [
                  ['name' => 'Nº serie'],
                  ['name' => 'Código'],
                  ['name' => 'Estado'],
                  ['name' => '¿En prestamo?'],
                  ['name' => 'Creado']
                ];
                include 'views/partials/thead-order.php'; ?>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($articles as $article) { ?>
              <tr data-id="<?= $article['_id'] ?>">
                <td><?= is_null($article['serial']) ? 'Ninguno' : $article['serial'] ?></td>
                <td><?= is_null($article['code']) ? 'Ninguno' : $article['code'] ?></td>
                <td><?= $article['status'] ?></td>
                <td>
                  <p class="p" ><?= $article['statusBorrowed'] ?></p>
                  <?php if($article['idPointOfSale']) { ?>
                  <a class="link text-blue" href="<?= url_base ?>incidence/borrowed/<?= $article['idIncidence'] ?>" tabindex="-1"><?= $article['name'] ?>/Incidencia Nº <?= $article['idIncidence'] ?></a>
                  <?php } ?>
                </td>
                <td><?= date_format(date_create($article['created']), 'd-m-Y'); ?></td>
                <td>
                <?php 
                $linkTable = [
                  'title' =>  'artículo '.$article['serial'],
                  'links' => [
                    [
                      'name' => 'Editar',
                      'type' =>  'update', 
                      'icon' => 'pen'
                    ],[
                      'name' => 'Eliminar',
                      'type' =>  'delete', 
                      'icon' => 'trash'
                    ]
                  ]
                ];
                include 'views/partials/dropdown-table-modal.php';
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
      </div>
    </div>
    <?php include 'views/partials/snackbar-modal.php'; ?>
  </div>
<!-- MODAL -->
<!-- MODAL ARTICLE ONLY -->
<div id="modal-new" class="modal d-none">
  <div class="modal-content">
    <div class="card-modal shadow-sm bg-white">
      <div class="card-body">
        <div class="d-flex j-between f-items-center pd-b-2">
          <p class="text-bold">Nuevo artículo</p>
          <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <form class="form article-new">
          <div class="form-box-input">
            <label class="label" for="serial">Nº de serie</label>
            <input class="ipt ipt-default" id="serial" name="serial" type="text" autocomplete="off"/>
          </div>
          <div class="form-box-input">
            <label class="label" for="observations">Observaciones</label>
            <textarea class="ipt ipt-default" id="observations" name="observations" type="text" autocomplete="off" rows="3"></textarea>
          </div>
          <div class="form-box-input">
            <label for="id_status">Estado</label>
            <div class="select">
            <select class="ipt ipt-default" id="id_status" name="id_status">
              <?php foreach ($articleOnlyStatus as $value) { ?>
                <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
              <?php } ?>
            </select>
            </div>
          </div>
          <div class="form-box-input">
            <label class="label" for="code">Código de artículo</label>
            <input class="ipt ipt-default" id="code" name="code" type="text" autocomplete="off"/>
          </div>
          <input class="ipt ipt-default" id="id_article" name="id_article" type="hidden" autocomplete="off" value="<?= $_GET['id'] ?>"/>
          <button class="btn btn-dark border-rd shadow-lg" type="submit">Guardar</button>
        </form>
        <div class="text-error text-bold text-red d-flex  f-column f-items-center"></div>
      </div>
    </div>  
  </div>
</div>
<!-- MODAL UPDATE ARTICLE ONLY -->
<div id="modal-update" class="modal d-none">
  <div class="modal-content">
    <div class="card-modal shadow-sm bg-white">
      <div class="card-body">
        <div class="d-flex j-between f-items-center pd-b-2">
          <p class="text-bold">Actualizar artículo</p>
          <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <form class="form article-update" data-url="controller=article&action=read">
          <div class="form-box-input">
            <label class="label" for="serial_update">Nº de serie</label>
            <input class="ipt ipt-default" id="serial_update" name="serial" type="text" autocomplete="off"/>
          </div>
          <div class="form-box-input">
            <label class="label" for="observations_update">Observaciones</label>
            <textarea class="ipt ipt-default" id="observations_update" name="observations" type="text" autocomplete="off" rows="3"></textarea>
          </div>
          <div class="form-box-input">
            <label for="id_status_update">Estado</label>
            <div class="select">
            <select class="ipt ipt-default" id="id_status_update" name="id_status">
              <?php foreach ($articleOnlyStatus as $value) { ?>
                <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
              <?php } ?>
            </select>
            </div>
          </div>
          <div class="form-box-input">
            <label class="label" for="code_update">Código de artículo</label>
            <input class="ipt ipt-default" id="code_update" name="code" type="text" autocomplete="off"/>
          </div>
          <input class="ipt ipt-default" id="id_update" name="id" type="hidden" autocomplete="off"/>

          <button class="btn btn-dark border-rd shadow-lg" type="submit">Guardar</button>
        </form>
        <div class="text-error-update text-bold text-red d-flex  f-column f-items-center"></div>
      </div>
    </div>  
  </div>
</div>
<!-- MODAL DELETE ARTICLE ONLY -->
<div id="modal-delete" class="modal d-none">
  <div class="modal-content">
    <div class="card-modal shadow-sm bg-white">
      <div class="card-body d-flex f-column j-content-center">
        <div class="d-flex j-between f-items-center pd-b-2">
          <p class="text-bold">Eliminar artículo</p>
          <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <p class="pd-b-2">¿Seguro que quieres eliminar el artículo <span class="text-bold text-ref-delete"></span> de la lista?</p>
        <button data-id="" class="btn btn-delete btn-article-delete btn-red border-rd shadow-lg" type="button">Si, quiero eliminar el artículo</button>
        <div class="text-error-delete text-bold text-red d-flex f-column f-items-center"></div>
      </div>
    </div>  
  </div>
</div>
<!-- FIN MODAL -->
</main>
<?php include 'views/partials/footer.php'; ?>