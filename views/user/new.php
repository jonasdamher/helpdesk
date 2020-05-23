<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    
    <section class="dashboard-header bg-blue">
      <?php 
      $url = 'controller';
      $nameSection = 'Nuevo usuario';
      include 'views/partials/header-action.php'; 
      ?>
    </section>

    <section class="bg-white dashboard-content shadow-sm">
      <form class="form" action="<?= url_base.$_GET['controller']?>/new" method="post" enctype="multipart/form-data">
        <div class="d-flex f-wrap"> 
          <fieldset class="fieldset col-6 col-12-md pd-r-1 pd-r-0-md">
            <legend class="text-bold">Datos de usuario</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-6 pd-r-1 pd-r-0-md col-12-md">
                <label class="label" for="name">Nombre</label>
                <input class="ipt ipt-default" id="name" name="name" type="text" value="<?= Utils::postCheck('name'); ?>" minLength="3" maxLength="32" required/>
              </div>
              <div class="form-box-input col-6 col-12-md">
                <label class="label" for="lastname">Apellidos</label>
                <input class="ipt ipt-default" id="lastname" name="lastname" type="text" value="<?= Utils::postCheck('lastname'); ?>" minLength="3" maxLength="32" required/>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="email">Email</label>
                <input class="ipt ipt-default" id="email" name="email" type="email" value="<?= Utils::postCheck('email'); ?>" maxLength="128" required/>
              </div>
              <div class="form-box-input col-12">
                <label class="btn btn-blue" for="image" aria-describedby="image-help">Imagen</label>
                <input class="d-none" id="image" name="image" type="file"/>
                <span id="image-help">Solo se permiten imagenes JPG, JPEG y PNG.</span>
              </div>
            </div>
          </fieldset>
          <fieldset class="fieldset col-6 col-12-md">
            <legend class="text-bold">Datos de sistema</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-12">
                <label class="label" for="password">Contraseña</label>
                <input aria-describedby="password-help" class="ipt ipt-default" id="password" name="password" type="password" autocomplete="off" value="<?= Utils::postCheck('password'); ?>" minLength="8" autocomplete="off" required/>
                <span id="password-help">Debe tener mayusculas, números y simbolos especiales.</span>
              </div>
              <div class="form-box-input col-12">
                <label class="label" for="password_repeat">Repetir contraseña</label>
                <input class="ipt ipt-default" id="password_repeat" name="password_repeat" type="password" autocomplete="off" value="<?= Utils::postCheck('password_repeat'); ?>" minLength="8" autocomplete="off" required/>
              </div>
              <div class="form-box-input col-6 pd-r-1 pd-r-0-sm col-12-sm">
                <label class="label" for="id_rol">Rol</label>
                <div class="select">
                  <select class="ipt ipt-default" id="id_rol" name="id_rol" required>
                    <?php foreach (Utils::postCheckSelect($roles, 'id_rol') as $value) { ?>
                      <option value="<?= $value['_id'] ?>"><?= $value['rol'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-box-input col-6 col-12-sm">
                <label class="label" for="id_status">Estado</label>
                    <div class="select">
                    <select class="ipt ipt-default" id="id_status" name="id_status" required>
                      <?php foreach (Utils::postCheckSelect($status, 'id_status') as $value) { ?>
                        <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
                      <?php } ?>
                    </select>
                    </div>
              </div>
            </div>
          </fieldset>
        </div>
        <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Registrar</button>
      </form>
      <?= $this->getResponseMessage(); ?>
    </section>

    <?php include 'views/partials/snackbar.php'; ?>

  </div>
</main>
<?php include 'views/partials/footer.php'; ?>