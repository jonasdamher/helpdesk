<header>
  <nav class="navbar-main" role="navigation" aria-label="Main menu">
    <div class="navbar bg-white shadow-sm">
      <div class="d-flex f-column f-items-center navbar-body">
        <section class="border-bottom pd-b-1">
          <div class="d-flex f-column f-items-center w-100">
            <?php 
              // IMAGE USER
              $dirImage = 'users/'.$_SESSION['image'];
              $titleImage = $_SESSION['name'].' '. $_SESSION['lastname'];
              $icon = 'user';
              include 'views/partials/image-64px.php';
            ?>
            <div class="d-flex f-column f-items-center">
              <p class="p text-bold"><?= $_SESSION['name'].' '. $_SESSION['lastname']; ?><p>
            </div>
            <ul class="navbar-nav d-flex f-column w-100">
              <li class="<?= Utils::activeNav('user','account') ?>">
                <a href="<?= url_base ?>user/account"><span><i class="fas fa-cog"></i></span>Cuenta</a>
              </li>
              <li>
                <a href="<?= url_base ?>user/logout"><span><i class="fas fa-sign-out-alt"></i></span>Cerrar sesión</a>
              </li>
              <li class="<?= Utils::activeNav('incidence', 'assigned') ?>">
                <a href="<?= url_base ?>incidence/assigned"><span><i class="fas fa-file"></i></span>Mis incidencias</a>
              </li>
            </ul>
          </div>
        </section>
        <section class="pd-t-1">
          <ul class="navbar-nav d-flex f-column">
            <?php include 'views/partials/nav/navUser-'.$_SESSION['rol'].'.php'; ?>
          </ul>
        </section>
      </div>
    </div>
    <div class="bg-navbar btn-navbar"></div>
  </nav>
</header>