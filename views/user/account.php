 <div class="container container-dashboard f-column">
   <section class="dashboard-header bg-blue">
     <div class="d-flex f-items-center">
       <?php include 'views/includes/button-navbar.php'; ?>
       <h1 class="h1 text-white">Mi cuenta</h1>
     </div>
   </section>
   <section class="dashboard-content d-flex f-column-xs pd-0">

     <div class="col-3 col-7-md col-12-sm bg-white pd-1 shadow-sm m-r-1">
       <div class="d-flex f-column f-items-center">
         <div class="pd-b-1">
           <?php
            $dirImage = 'users/' . $_SESSION['image'];
            $titleImage = $_SESSION['name'] . ' ' . $_SESSION['lastname'];
            $sizeImage='128';
            $icon = 'user';
            include 'views/includes/image.php';
            ?>
         </div>
         <div class="d-flex f-column f-items-center">
           <div class="pd-b-1 text-blue"><?= $user['name'] ?> <?= $user['lastname'] ?></div>
           <div class="d-flex j-content-center pd-b-1 m-b-1 w-100 text-bold text-gray border-bottom"><?= $user['rol'] ?></div>
           <div><?= $user['email'] ?></div>
         </div>
       </div>
     </div>
     <div class="col-6 col-7-md col-12-sm bg-white pd-1 shadow-sm m-r-1">
       <div class="d-flex f-column f-items-center">

       </div>
     </div>
     <div class="col-3 col-5-md col-12-sm bg-white pd-1 shadow-sm">
       <form class="form" action="<?= URL_BASE . '/user/account' ?>" method="post">
         <div class="form-box-input">
           <label class="label" for="currentPassword">Contraseña Actual</label>
           <input class="ipt ipt-default" id="currentPassword" name="currentPassword" type="password" autocomplete="off" value="<?= Utils::postCheck('currentPassword'); ?>" minLength="8" autocomplete="off" required />
         </div>
         <div class="form-box-input">
           <label class="label" for="password">Nueva contraseña</label>
           <input aria-describedby="password-help" class="ipt ipt-default" id="password" name="password" type="password" autocomplete="off" value="<?= Utils::postCheck('password'); ?>" minLength="8" autocomplete="off" required />
           <span id="password-help">Debe tener mayusculas, números y simbolos especiales.</span>
         </div>
         <div class="form-box-input">
           <label class="label" for="password_repeat">Repetir contraseña</label>
           <input class="ipt ipt-default" id="password_repeat" name="password_repeat" type="password" autocomplete="off" value="<?= Utils::postCheck('password_repeat'); ?>" minLength="8" autocomplete="off" required />
         </div>
         <button class="btn btn-default btn-dark border-rd shadow-lg" type="submit">Actualizar contraseña</button>
       </form>
       <?= $this->getResponseMessage() ?>
     </div>
   </section>
   <?php include 'views/includes/snackbar.php'; ?>
 </div>