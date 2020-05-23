<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    
    <section class="dashboard-header bg-blue">
      <?php 
      $url = 'controller';
      $nameSection = 'Ficha de usuario';
      include 'views/partials/header-action.php'; 
      ?>
    </section>

    <section class="bg-white dashboard-content shadow-sm">
      <form class="form" action="<?= url_base.$_GET['controller'].'/update/'.$_GET['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="d-flex f-wrap"> 
          <fieldset class="fieldset col-6 col-12-md">
            <legend class="text-bold">Datos de usuario</legend>
            <div class="d-flex f-wrap">
              <div class="d-flex f-column f-items-center col-2 col-3-md col-12-sm">
                <?php 
                  $dirImage = 'users/'.$user['image'];
                  $titleImage = $user['name'].' '. $user['lastname'];
                  $icon = 'user';
                  include 'views/partials/image-64px.php';
                ?>
                <div class="form-box-input pd-0">
                  <label class="btn btn-blue f-self-center" for="image" aria-describedby="image-help">Imagen</label>
                  <input class="d-none" id="image" name="image" type="file"/>
                  <span id="image-help">Solo se permiten imagenes JPG, JPEG y PNG.</span>
                </div>
              </div>
              <div class="col-10 col-9-md col-12-sm">
                <div class="form-box-input">
                  <label class="label" for="name">Nombre</label>
                  <input class="ipt ipt-default" id="name" name="name" type="text" placeholder="Introduce el nombre..." value="<?= $user['name']; ?>" minLength="3" maxLength="32" required/>
                </div>
                <div class="form-box-input">
                  <label class="label" for="lastname">Apellidos</label>
                  <input class="ipt ipt-default" id="lastname" name="lastname" type="text" placeholder="Introduce los apellidos..." value="<?= $user['lastname']; ?>" minLength="3" maxLength="32" required/>
                </div>
                <div class="form-box-input">
                  <label class="label" for="email">Email</label>
                  <input class="ipt ipt-default" id="email" name="email" type="email" placeholder="Introduce el email..." value="<?= $user['email']; ?>" maxLength="128" required/>
                </div>               
              </div>
            </div>
          </fieldset>
          <fieldset class="fieldset col-6 col-12-md">
            <legend class="text-bold">Datos de sistema</legend>
            <div class="d-flex f-wrap">
              <div class="form-box-input col-6">
                <label for="id_rol">Rol</label>
                <div class="select">
                  <select class="ipt ipt-default" id="id_rol" name="id_rol" required>
                    <?php foreach (Utils::resultCheckSelect($roles, $user['_id_rol']) as $value) { ?>
                      <option value="<?= $value['_id'] ?>"><?= $value['rol'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-box-input col-6">
                <label for="id_status">Estado</label>
                <div class="select">
                  <select class="ipt ipt-default" id="id_status" name="id_status" equired="required">
                    <?php foreach (Utils::resultCheckSelect($status, $user['_id_status']) as $value) { ?>
                      <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </fieldset>
        </div>      
        <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Guardar</button>
      </form>
     <?= $this->getResponseMessage() ?>
    </section>

    <?php include 'views/partials/snackbar.php'; ?>

  </div>
</main>
<?php include 'views/partials/footer.php'; ?>