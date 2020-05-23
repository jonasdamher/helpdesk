<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    
    <section class="dashboard-header dashboard-tab bg-blue d-flex f-column">
      <?php 
      $url = 'controller';
      $nameSection = 'Ficha de punto de venta';
      include 'views/partials/header-action.php'; 
      ?>
      <?php include 'views/partials/tab.php'; ?>
    </section>

    <section class="bg-white dashboard-content shadow-sm">
     
      <div class="d-flex j-evenly f-wrap j-content-start-sm">
        <div class="pd-b-1">
          <p class="p text-bold">Punto de venta</p>
          <p class="p">Nombre: <?= $pointOfSale['name'] ?></p>
          <p class="p">Código: <?= $pointOfSale['company_code'] ?></p>
          <p class="p">Estado <?= $pointOfSale['status'] ?></p>
          <p>Creado el <?= $pointOfSale['created'] ?></p>
        </div>
        <div class="pd-b-1">
          <p class="p text-bold">Punto de venta perteneciente</p>
          <p class="p">Razón social: <?= $pointOfSale['business_name'] ?></p>
          <p>Nombre comercial: <?= $pointOfSale['tradename'] ?></p>
        </div>
        <div class="pd-b-1">
          <p class="p text-bold">Localización</p>
          <p class="p">País: <?= $pointOfSale['namecountry'] ?></p>
          <p class="p">Provincia: <?= $pointOfSale['province'] ?></p>
          <p class="p">Localidad: <?= $pointOfSale['locality'] ?></p>
          <p class="p">Código postal: <?= $pointOfSale['postal_code'] ?></p>
          <p>Dirección: <?= $pointOfSale['address'] ?></p>
        </div>
      </div>

      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex f-items-end w-100-sm">
          <button id="btn-open-modal-new" class="btn border-rd btn-dark shadow-lg" type="button"><span><i class="fas fa-plus"></i></span>Añadir Contacto</button>
        </div>
      </div>

      <div id="table-details" class="<?= !empty($contacts) ? '' : 'd-none' ?>">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <?php 
                $thead = [
                  ['name' => 'Nombre'],
                  ['name' => 'Teléfono'],
                  ['name' => 'Email']
                ];
                include 'views/partials/thead-order.php'; ?>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($contacts as $contact) { ?>
              <tr data-id="<?= $contact['_id'] ?>">
                <td><?= $contact['name'] ?></td>
                <td><?= is_null($contact['phone']) ? 'Ninguno' : $contact['phone'] ?></td>
                <td><?= $contact['email'] ?></td>
                <td>
                <?php 
                $linkTable = [
                  'title' =>  'contacto '.$contact['name'],
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
                <td colspan="4">
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
  <!-- MODAL -->
  <!-- MODAL NEW CONTACT -->
  <div id="modal-new" class="modal d-none">
    <div class="modal-content">
      <div class="card-modal shadow-sm bg-white">
        <div class="card-body">
          <div class="d-flex j-between f-items-center pd-b-2">
            <p class="text-bold">Nuevo contacto</p>
            <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
          </div>
          <form class="form contact-new" autocomplete="off">
            <div class="form-box-input">
              <label class="label" for="name">Nombre de contacto</label>
              <input class="ipt ipt-default" id="name" name="name" type="text"/>
            </div>
            <div class="form-box-input">
              <label class="label" for="phone">Teléfono</label>
              <input class="ipt ipt-default" id="phone" name="phone" type="tel"/>
            </div>
            <div class="form-box-input">
              <label class="label" for="email">Email</label>
              <input class="ipt ipt-default" id="email" name="email" type="email"/>
            </div>
            <input class="ipt ipt-default" id="id" name="id" type="hidden" value="<?= $_GET['id'] ?>"/>
            <button class="btn btn-dark shadow-lg border-rd" type="submit"><span><i class="fas fa-plus"></i></span>Registrar</button>
          </form>
          <div class="text-error text-bold text-red d-flex  f-column f-items-center"></div>
        </div>
      </div>  
    </div>
  </div>
  <!-- MODAL UPDATE CONTACT -->
  <div id="modal-update" class="modal d-none">
    <div class="modal-content">
      <div class="card-modal shadow-sm bg-white">
        <div class="card-body">
          <div class="d-flex j-between f-items-center pd-b-2">
            <p class="text-bold">Actualizar contacto</p>
            <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
          </div>
          <form class="form contact-update" data-url="controller=contactPointOfSale&action=read">
            <div class="form-box-input">
              <label class="label" for="name_update">Nombre de contacto</label>
              <input class="ipt ipt-default" id="name_update" name="name" type="text" autocomplete="off"/>
            </div>
            <div class="form-box-input">
              <label class="label" for="phone_update">Teléfono</label>
              <input class="ipt ipt-default" id="phone_update" name="phone" type="text" autocomplete="off"/>
            </div>
            <div class="form-box-input">
              <label class="label" for="email_update">Email</label>
              <input class="ipt ipt-default" id="email_update" name="email" type="text" autocomplete="off"/>
            </div>
            <input class="ipt ipt-default" id="id_update" name="id" type="hidden" autocomplete="off"/>
            <button class="btn btn-dark shadow-lg border-rd" type="submit"><span><i class="fas fa-save"></i></span>Guardar</button>
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
            <p class="text-bold">Eliminar contacto</p>
            <button class="btn text-red close-modal" type="button" aria-label="Cerrar" title="Cerrar"><i class="fas fa-times fa-lg"></i></button>
          </div>
          <p class="pd-b-2">¿Seguro que quieres eliminar al contacto <span class="text-bold text-ref-delete"></span> de la lista?</p>
          <button data-id="" class="btn btn-delete btn-contact-delete border-rd btn-red shadow-lg" type="button">Si, quiero eliminar el contacto</button>
          <div class="text-error-delete text-bold text-red d-flex f-column f-items-center"></div>
        </div>
      </div>  
    </div>
  </div>
  <!-- FIN MODAL -->
</main>
<?php include 'views/partials/footer.php'; ?>