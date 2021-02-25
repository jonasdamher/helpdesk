 <div class="container container-dashboard f-column">

   <section class="dashboard-header dashboard-tab bg-blue d-flex f-column">
     <?php
      $url = 'controller';
      $nameSection = 'Actualizar punto de venta';
      include 'views/includes/header-action.php';
      ?>
     <?php include 'views/includes/tab.php'; ?>
   </section>

   <section class="bg-white dashboard-content shadow-sm">
     <form class="form" action="<?= URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'] ?>" method="post">
       <div class="d-flex f-wrap">
         <fieldset class="fieldset col-6 col-12-md pd-r-1 pd-r-0-md">
           <legend class="text-bold">Datos de punto de venta</legend>
           <div class="d-flex f-wrap">
             <div class="form-box-input col-12">
               <label class="label" for="name">Nombre de punto de venta</label>
               <input class="ipt ipt-default" id="name" name="name" type="text" value="<?= $pointOfSale['name'] ?>" required />
             </div>
             <div class="form-box-input col-12">
               <label class="label" for="company_code">Código de punto de venta</label>
               <input class="ipt ipt-default" id="company_code" name="company_code" type="text" value="<?= $pointOfSale['company_code'] ?>" />
             </div>
             <div class="form-box-input col-6 pd-r-1 col-12-sm pd-r-0-sm">
               <label for="id_company">Empresa</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_company" name="id_company">
                   <?php foreach (Utils::resultCheckSelect($companies, $pointOfSale['_id_company']) as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['business_name'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="form-box-input col-6 col-12-sm">
               <label for="id_status">Estado</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_status" name="id_status">
                   <?php foreach (Utils::resultCheckSelect($status, $pointOfSale['_id_status']) as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
           </div>
         </fieldset>
         <fieldset class="fieldset col-6 col-12-md">
           <legend class="text-bold">Localización</legend>
           <div class="d-flex f-wrap">
             <div class="form-box-input col-12">
               <label class="label" for="viewing-country">País</label>
               <div class="datalist">
                 <input class="ipt ipt-default viewing-country" id="viewing-country" list="country" type="text" autocomplete="off" value="<?= $country ?>" autocomplete="off" />
                 <datalist id="country">
                   <?php foreach (Utils::resultCheckSelect($countries, $pointOfSale['_id_country']) as $country) { ?>
                     <option data-id="<?= $country['_id'] ?>" value="<?= $country['name'] ?>"></option>
                   <?php } ?>
                 </datalist>
               </div>
             </div>
             <div class="form-box-input col-12">
               <label class="label" for="address">Dirección</label>
               <div class="datalist">
                 <input class="ipt ipt-default" id="address" name="address" type="text" value="<?= $pointOfSale['address'] ?>" placeholder="" onFocus="geolocate(event)" autocomplete="off" />
               </div>
             </div>
             <div class="form-box-input col-12">
               <label class="label" for="administrative_area_level_2">Provincia</label>
               <input class="ipt ipt-default" id="administrative_area_level_2" name="province" type="text" value="<?= $pointOfSale['province'] ?>" autocomplete="off" />
             </div>
             <div class="form-box-input col-6 pd-r-1 col-6-md pd-r-0-xs">
               <label class="label" for="locality">Localidad</label>
               <input class="ipt ipt-default" id="locality" name="locality" type="text" value="<?= $pointOfSale['locality'] ?>" autocomplete="off" />
             </div>
             <div class="form-box-input col-6 col-6-md">
               <label class="label" for="postal_code">Código postal</label>
               <input class="ipt ipt-default" id="postal_code" name="postal_code" type="text" value="<?= $pointOfSale['postal_code'] ?>" maxlength="5" autocomplete="off" />
             </div>
           </div>
         </fieldset>
       </div>
       <input id="id_country" name="id_country" type="hidden" value="<?= $pointOfSale['_id_country'] ?>" />
       <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Guardar</button>
     </form>
     <?= $this->getResponseMessage(); ?>
   </section>

   <?php include 'views/includes/snackbar.php'; ?>

 </div>