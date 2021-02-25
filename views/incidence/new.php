 <div class="container container-dashboard f-column">
   <section class="dashboard-header bg-blue">
     <?php
      $url = 'controller';
      $nameSection = 'Nueva incidencia';
      include 'views/includes/header-action.php';
      ?>
   </section>
   <section class="bg-white dashboard-content shadow-sm">
     <form class="form" action="<?= URL_BASE . $_GET['controller'] ?>/new" method="post">
       <div class="d-flex f-wrap">
         <div class="col-6 pd-r-1 col-12-md pd-r-0-md">
           <div class="d-flex f-wrap">
             <div class="form-box-input col-12">
               <label class="label" for="subject">Asunto</label>
               <input class="ipt ipt-default" id="subject" name="subject" type="text" value="<?= Utils::postCheck('subject'); ?>" maxlength="128" required />
             </div>
             <div class="form-box-input col-12">
               <label class="label" for="description">Descripción</label>
               <textarea class="ipt ipt-default row-5" id="description" name="description" type="text" autocomplete="off" maxlength="1024"><?= Utils::postCheck('description'); ?></textarea>
             </div>
           </div>
         </div>
         <div class="col-6 pd-r-1 col-12-md pd-r-0-md">
           <div class="d-flex f-wrap">
             <div class="form-box-input col-6 pd-r-1 col-12-md pd-r-0-md">
               <label for="id_status">Estado</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_status" name="id_status" required>
                   <?php foreach ($status['family'] as $family) { ?>
                     <optgroup label="<?= $family['name'] ?>">
                       <?php foreach (Utils::postCheckSelect($status['status'], 'id_status') as $sectionStatus) {
                          if ($family['_id'] == $sectionStatus['_id_family']) { ?>
                           <option value="<?= $sectionStatus['_id'] ?>"><?= $sectionStatus['status'] ?></option>
                       <?php }
                        } ?>
                     </optgroup>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="form-box-input col-6 col-12-md">
               <label for="id_attended">Usuario asignado</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_attended" name="id_attended" required>
                   <?php foreach (Utils::postCheckSelect($users, 'id_attended') as $value) { ?>
                     <?php if ($value['_id'] == $_SESSION['user_init']) { ?>
                       <option value="<?= $value['_id'] ?>" select><?= $value['name'] . ' ' . $value['lastname'] ?></option>
                     <?php } else { ?>
                       <option value="<?= $value['_id'] ?>"><?= $value['name'] . ' ' . $value['lastname'] ?></option>
                     <?php } ?>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="form-box-input col-6 pd-r-1 col-12-md pd-r-0-md">
               <label for="id_priority">Prioridad</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_priority" name="id_priority" required>
                   <?php foreach (Utils::postCheckSelect($priorities, 'id_priority') as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['priority'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="form-box-input col-6 col-12-md">
               <label for="id_type">Tipo de incidencia</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_type" name="id_type" required>
                   <?php foreach (Utils::postCheckSelect($types, 'id_type') as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['type'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="form-box-input col-12">
               <label for="id_pto_of_sales">Punto de venta</label>
               <div class="select">
                 <select class="ipt ipt-default" id="id_pto_of_sales" name="id_pto_of_sales" required>
                   <?php foreach (Utils::postCheckSelect($pointsOfSales, 'id_pto_of_sales') as $value) { ?>
                     <option value="<?= $value['_id'] ?>"><?= $value['name'] . ' ' . $value['company_code'] ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
           </div>
         </div>
       </div>
       <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Registrar</button>
     </form>
     <?= $this->getResponseMessage(); ?>
   </section>
 </div>