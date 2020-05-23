<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php 
      $url = 'controller';
      $nameSection = 'Nuevo proveedor';
      include 'views/partials/header-action.php'; ?>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
      <form class="form" action="<?= url_base.$_GET['controller']?>/new" method="post">
        <div class="d-flex f-wrap"> 
          <fieldset class="fieldset col-6 col-12-md pd-r-1 pd-r-0-md">
            <legend class="text-bold">Datos de proveedor</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-12">
                <label class="label" for="tradename">Nombre comercial</label>
                <input class="ipt ipt-default" id="tradename" name="tradename" type="text" value="<?= Utils::postCheck('tradename'); ?>" maxLength="64" autocomplete="off" required/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="business_name">Razón social</label>
                <input class="ipt ipt-default" id="business_name" name="business_name" type="text" value="<?= Utils::postCheck('business_name'); ?>" maxLength="64" autocomplete="off" required/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="cif">CIF/NIF</label>
                <input class="ipt ipt-default" id="cif" name="cif" type="text" value="<?= Utils::postCheck('cif'); ?>" maxLength="64" required/>
              </div>
              <div class="form-box-input col-6 pd-r-1 col-12-md pd-r-1-md">
                <label class="label" for="phone">Teléfono</label>
                <input class="ipt ipt-default" id="phone" name="phone" type="tel" value="<?= Utils::postCheck('phone'); ?>" maxLength="9" required/>
              </div>
              <div class="form-box-input col-6 col-12-md">
                <label class="label" for="email">Email</label>
                <input class="ipt ipt-default" id="email" name="email" type="email" value="<?= Utils::postCheck('email'); ?>" maxLength="128" required/>
              </div>
            </div>
          </fieldset>
          <fieldset class="fieldset col-6 col-12-md">
            <legend class="text-bold">Localización</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-12">
                <label class="label" for="viewing-country">País</label>
                <div class="datalist">
                  <input class="ipt ipt-default viewing-country" id="viewing-country" name="country" list="country" type="text" value="<?= Utils::postCheck('country'); ?>" autocomplete="off"/>
                  <datalist id="country">
                    <?php foreach($countries as $country) { ?>
                    <option data-id="<?= $country['_id'] ?>" value="<?= $country['name'] ?>"></option>
                    <?php } ?>
                  </datalist>
                </div>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="address">Dirección</label>
                <input class="ipt ipt-default" id="address" name="address" type="text" value="<?= Utils::postCheck('address') ?>" placeholder="" onFocus="geolocate(event)" autocomplete="off"/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="administrative_area_level_2">Provincia</label>
                <input class="ipt ipt-default" id="administrative_area_level_2" name="province" type="text" value="<?= Utils::postCheck('province'); ?>" maxLength="32"/>
              </div>
              <div class="form-box-input col-6 pd-r-1 col-6-md pd-r-0-xs">
                <label class="label" for="locality">Localidad</label>
                <input class="ipt ipt-default" id="locality" name="locality" type="text" value="<?= Utils::postCheck('locality'); ?>" maxLength="32"/>
              </div>
              <div class="form-box-input col-6 col-6-md">
                <label class="label" for="postal_code">Código postal</label>
                <input class="ipt ipt-default" id="postal_code" name="postal_code" type="number" value="<?= Utils::postCheck('postal_code'); ?>" maxLength="5"/>
              </div>
            </div>
          </fieldset>
        </div>          
        <input id="id_country" name="id_country" type="hidden"/>
        <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Registrar</button>
      </form>
      <?= $this->getResponseMessage(); ?>
    </section>
  </div>
</main>
<?php include 'views/partials/script-places.php'; ?>
<?php include 'views/partials/footer.php'; ?>