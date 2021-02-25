 <div class="container container-dashboard f-column">
   <div class="dashboard-header bg-blue">
     <?php
      $url = 'controller';
      $nameSection = 'Nuevo artículo';
      include 'views/includes/header-action.php';
      ?>
   </div>
   <div class="bg-white dashboard-content shadow-sm">
     <form class="form" action="<?= URL_BASE . $_GET['controller'] ?>/new" method="post" enctype="multipart/form-data">
       <div class="d-flex f-wrap">
         <fieldset class="fieldset col-12">
           <legend class="text-bold">Datos de producto</legend>
           <div class="d-flex f-wrap">
             <div class="form-box-input col-12">
               <label class="btn btn-blue" for="image" aria-describedby="image-help">Imagen</label>
               <input class="d-none" id="image" name="image" type="file" />
               <span id="image-help">Solo se permiten imagenes JPG, JPEG y PNG.</span>
             </div>
             <div class="form-box-input col-12">
               <label class="label" for="name">Nombre de artículo</label>
               <input class="ipt ipt-default" id="name" name="name" type="text" value="<?= Utils::postCheck('name'); ?>" maxlength="128" required />
             </div>
             <div class="form-box-input col-12">
               <label class="label" for="description">Descripción</label>
               <textarea class="ipt ipt-default" id="description" name="description" autocomplete="off" rows="4" maxlength="1024"><?= Utils::postCheck('description'); ?></textarea>
             </div>
             <div class="form-box-input col-6 col-12-md pd-r-1 pd-r-0-md">
               <label class="label" for="barcode">Código de barras</label>
               <input class="ipt ipt-default" id="barcode" name="barcode" type="text" value="<?= Utils::postCheck('barcode'); ?>" maxlength="24" required />
             </div>
             <div class="form-box-input col-6 col-12-md">
               <label for="id_type">Tipo de artículo</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_type" name="id_type" required>
                   <?php foreach (Utils::postCheckSelect($types, 'id_type') as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['type'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
           </div>
         </fieldset>
         <fieldset class="fieldset col-12">
           <legend class="text-bold">Datos de proveedor</legend>
           <div class="d-flex f-wrap">
             <div class="form-box-input col-12">
               <label for="id_provider">Proveedor</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_provider" name="id_provider" required>
                   <?php foreach (Utils::postCheckSelect($providers, 'id_provider') as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['business_name'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="form-box-input col-6 col-12-sm pd-r-1 pd-r-0-sm">
               <label class="label" for="cost">Costo</label>
               <input class="ipt ipt-default" id="cost" name="cost" type="text" value="<?= Utils::postCheck('cost'); ?>" />
             </div>
             <div class="form-box-input col-6 col-12-sm">
               <label class="label" for="pvp">PVP</label>
               <input class="ipt ipt-default" id="pvp" name="pvp" type="text" value="<?= Utils::postCheck('pvp'); ?>" />
             </div>
           </div>
         </fieldset>
       </div>
       <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Registrar</button>
     </form>
     <?= $this->getResponseMessage(); ?>
   </div>
 </div>