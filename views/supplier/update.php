<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php 
      $url = 'controller';
      $nameSection = 'Actualizar proveedor';
      include 'views/partials/header-action.php'; ?>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
      <form class="form" action="<?= url_base.$_GET['controller'].'/update/'.$_GET['id'] ?>" method="post">
      <div class="d-flex f-wrap"> 
          <fieldset class="fieldset col-6 col-12-md pd-r-1 pd-r-0-md">
            <legend class="text-bold">Datos de proveedor</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-12">
                <label class="label" for="tradename">Nombre comercial</label>
                <input class="ipt ipt-default" id="tradename" name="tradename" type="text" value="<?= $supplier['tradename'] ?>" maxLength="64" autocomplete="off" required/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="business_name">Razón social</label>
                <input class="ipt ipt-default" id="business_name" name="business_name" type="text" value="<?= $supplier['business_name'] ?>" maxLength="64" autocomplete="off" required/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="cif">CIF/NIF</label>
                <input class="ipt ipt-default" id="cif" name="cif" type="text" value="<?= $supplier['cif'] ?>" maxLength="64" required/>
              </div>
              <div class="form-box-input col-6 pd-r-1 col-12-md pd-r-1-md">
                <label class="label" for="phone">Teléfono</label>
                <input class="ipt ipt-default" id="phone" name="phone" type="tel" value="<?= $supplier['phone'] ?>" maxLength="9"/>
              </div>
              <div class="form-box-input col-6 col-12-md">
                <label class="label" for="email">Email</label>
                <input class="ipt ipt-default" id="email" name="email" type="email" value="<?=  $supplier['email']  ?>" maxLength="128"/>
              </div>
            </div>
          </fieldset>
          <fieldset class="fieldset col-6 col-12-md">
            <legend class="text-bold">Localización</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-12">
                <label class="label" for="viewing-country">País</label>
                <input class="ipt ipt-default viewing-country" id="viewing-country" list="country" type="text" autocomplete="off" value="<?= $country ?>"/>
                <datalist id="country">
                  <?php foreach(Utils::resultCheckSelect($countries, $pointOfSale['_id_country']) as $country) { ?>
                  <option data-id="<?= $country['_id'] ?>" value="<?= $country['name'] ?>"></option>
                  <?php } ?>
                </datalist>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="address">Dirección</label>
                <input class="ipt ipt-default" id="address" name="address" type="text" value="<?= $supplier['address'] ?>" placeholder="" onFocus="geolocate(event)" autocomplete="off"/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="administrative_area_level_2">Provincia</label>
                <input class="ipt ipt-default" id="administrative_area_level_2" name="province" type="text" value="<?= $supplier['province'] ?>" maxLength="32"/>
              </div>
              <div class="form-box-input col-6 pd-r-1 col-6-md pd-r-0-xs">
                <label class="label" for="locality">Localidad</label>
                <input class="ipt ipt-default" id="locality" name="locality" type="text" value="<?= $supplier['locality'] ?>" maxLength="32"/>
              </div>
              <div class="form-box-input col-6 col-6-md">
                <label class="label" for="postal_code">Código postal</label>
                <input class="ipt ipt-default" id="postal_code" name="postal_code" type="number" value="<?= $supplier['postal_code'] ?>" maxLength="5"/>
              </div>
            </div>
          </fieldset>
        </div>
        <input id="id_country" name="id_country" type="hidden" value="<?= $supplier['_id_country'] ?>"/>
        <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Guardar</button>
      </form>
      <?= $this->getResponseMessage() ?>
    </section>
    <?php include 'views/partials/snackbar.php'; ?>
  </div>
</main>
<?php include 'views/partials/script-places.php'; ?>
<?php include 'views/partials/footer.php'; ?>