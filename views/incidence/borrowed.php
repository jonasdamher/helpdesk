<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php 
      $url = 'details';
      $nameSection = 'Artículos en prestamo';
      include 'views/partials/header-action.php'; 
      ?>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex f-items-end w-100-sm">
          <button id="btn-open-modal-new" class="btn btn-dark border-rd shadow-lg" type="button"><span><i class="fas fa-plus"></i></span>Artículo en prestamo</button>
        </div>
      </div>
      <div id="table-details" class="<?= !empty($articlesBorrowed) ? '' : 'd-none' ?>">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <?php 
                $thead = [
                  ['name' => 'Nombre'],
                  ['name' => 'Nº serie'],
                  ['name' => 'Código de barras'],
                  ['name' => 'Código']
                ];
                include 'views/partials/thead-order.php'; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($articlesBorrowed as $article) { ?>
              <tr data-id="<?= $article['_id'] ?>">
                <td>
                  <p class="p text-bold"><?= $article['name'] ?></p>
                  <p><?= (is_null($article['observations']) ) ? '' : mb_substr($article['observations'], 0, 50).'...' ?></p>
                </td>
                <td><?= is_null($article['serial']) ? 'Ninguno' : $article['serial'] ?></td>
                <td><?= is_null($article['barcode']) ? 'Ninguno' : $article['barcode'] ?></td>
                <td><?= is_null($article['code']) ? 'Ninguno' : $article['code'] ?></td>
                <td>
                <?php 
                $linkTable = [
                  'title' =>  'artículo '.$article['name'].' '.$article['serial'],
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
                <td colspan="5">
                  <div class="d-flex j-content-end">
                    <?php include 'views/partials/pagination.php'; ?>
                  </div>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
    <?php include 'views/partials/snackbar-modal.php'; ?>
  </div>

<!-- MODAL ARTICLE BORROWED -->
<div id="modal-new" class="modal d-none">
  <div class="modal-content">
    <div class="card-modal shadow-sm bg-white">
      <div class="card-body">
        <div class="d-flex j-between f-items-center pd-b-2">
          <p class="text-bold">Añadir artículo en prestamo</p>
          <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <form class="form articleBorrowed-new">
          <div class="form-box-input">
            <label class="label" for="viewing_article">Buscar artículo</label>
            <div class="datalist">
              <input class="ipt ipt-default viewing-article" list="article" id="viewing_article" name="viewing_article" autocomplete="off" />
              <datalist id="article">
              <?php foreach ($articles as $value) { ?>
                <option data-id="<?= $value['_id'] ?>" value="<?= $value['name'].' - '.$value['serial'] ?> "></option>
              <?php } ?>
              </datalist>
            </div>
          </div>
          <input id="id_article_only" name="id_article_only" type="hidden"/>
          <input id="id_incidence" name="id_incidence" type="hidden" value="<?= $_GET['id'] ?>"/>
          <input id="id_pto" name="id_pto" type="hidden" value="<?= $incidence['_id_pto_of_sales'] ?>"/>
          <button class="btn btn-dark border-rd shadow-lg" type="submit">Guardar</button>
        </form>
        <div class="text-error text-bold text-red d-flex f-column f-items-center"></div>
      </div>
    </div>  
  </div>
</div>
<!-- MODAL UPDATE ARTICLE BORROWED -->
<div id="modal-update" class="modal d-none">
  <div class="modal-content">
   <div class="card-modal shadow-sm bg-white">
      <div class="card-body">
        <div class="d-flex j-between f-items-center pd-b-2">
          <p class="text-bold">Actualizar artículo en prestamo</p>
          <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <form class="form articleBorrowed-update" data-url="controller=ArticleBorrowed&action=read">
          <div class="form-box-input">
            <label for="id_article_only_update">Artículo</label>
            <div class="select">
            <select class="ipt ipt-default" id="id_article_only_update" name="id_article_only" autocomplete="off">
            <?php foreach ($articles as $value) { ?>
              <option value="<?= $value['_id'] ?>"><?= $value['name'].' - '.$value['serial'] ?></option>
            <?php } ?>
            </select>
            </div>
          </div>
          <div class="form-box-input">
            <label for="id_borrowed_status_update">¿En prestamo?</label>
            <div class="select">
            <select class="ipt ipt-default" id="id_borrowed_status_update" name="id_borrowed_status" autocomplete="off">
            <?php foreach ($borroweStatus as $value) { ?>
              <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
            <?php } ?>
            </select>
            </div>
          </div>
          <input id="id_update" name="id" type="hidden" autocomplete="off"/>
          <input id="id_incidence" name="id_incidence" type="hidden" value="<?= $_GET['id'] ?>"/>

          <button class="btn btn-dark border-rd shadow-lg" type="submit">Guardar</button>
        </form>
        <div class="text-error-update text-bold text-red d-flex f-column f-items-center"></div>
      </div>
    </div>  
  </div>
</div>
<!-- MODAL DELETE ARTICLE BORROWED -->
<div id="modal-delete" class="modal d-none">
  <div class="modal-content">
    <div class="card-modal shadow-sm bg-white">
      <div class="card-body d-flex f-column j-content-center">
        <div class="d-flex j-between f-items-center pd-b-2">
          <p class="text-bold">Eliminar artículo en prestamo</p>
          <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <p class="pd-b-2">¿Seguro que quieres eliminar el artículo <span class="text-bold text-ref-delete"></span> de la lista?</p>
        <button data-id="" class="btn btn-delete btn-articleBorrowed-delete btn-red border-rd shadow-lg" type="button">Si, quiero eliminar el artículo</button>
        <div class="text-error-delete text-bold text-red d-flex f-column f-items-center"></div>
      </div>
    </div>  
  </div>
</div>

</main>
<?php include 'views/partials/footer.php'; ?>