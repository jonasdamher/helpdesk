 <div class="container container-dashboard f-column">
   <section class="dashboard-header bg-blue">
     <?php
      $url = 'controller';
      $nameSection = 'Ficha de empresa';
      include 'views/includes/header-action.php'; ?>
   </section>
   <section class="bg-white dashboard-content shadow-sm">
     <form class="form" action="<?= URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'] ?>" method="post">
       <div class="d-flex f-wrap">
         <div class="form-box-input col-6 col-12-md pd-r-1 pd-r-0-md">
           <label class="label" for="tradename">Nombre comercial</label>
           <input class="ipt ipt-default" id="tradename" name="tradename" type="text" value="<?= $company['tradename'] ?>" maxLength="64" required />
         </div>
         <div class="form-box-input col-6 col-12-md">
           <label class="label" for="business_name">Razón social</label>
           <input class="ipt ipt-default" id="business_name" name="business_name" type="text" value="<?= $company['business_name'] ?>" maxLength="64" required />
         </div>
         <div class="form-box-input col-6 col-12-md pd-r-1 pd-r-0-md">
           <label class="label" for="cif">CIF/NIF</label>
           <input class="ipt ipt-default" id="cif" name="cif" type="text" value="<?= $company['cif'] ?>" maxLength="64" required />
         </div>
         <div class="form-box-input col-6 col-12-md">
           <label for="id_status">Estado</label>
           <div class="select">
             <select class="ipt ipt-default" id="id_status" name="id_status" required>
               <?php foreach (Utils::resultCheckSelect($status, $company['_id_status']) as $value) { ?>
                 <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
               <?php } ?>
             </select>
           </div>
         </div>
       </div>
       <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Guardar</button>
     </form>
     <?= $this->getResponseMessage() ?>
   </section>
   <?php include 'views/includes/snackbar.php'; ?>
 </div>