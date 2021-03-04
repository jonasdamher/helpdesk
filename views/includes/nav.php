<header>
  <nav class="navbar-main" role="navigation" aria-label="Main menu">
    <div class="navbar bg-white shadow-sm">
      <div class="d-flex f-column f-items-center navbar-body">
        <section class="border-bottom pd-b-1">
          <div class="d-flex f-column f-items-center w-100">
            <!-- user account -->
            <?php
            $dirImage = 'users/' . $_SESSION['image'];
            $titleImage = $_SESSION['name'] . ' ' . $_SESSION['lastname'];
            $icon = 'user';
            $sizeImage = '64';
            include 'views/includes/image.php';
            ?>
            <div class="d-flex f-column f-items-center">
              <p class="p text-bold"><?= $_SESSION['name'] . ' ' . $_SESSION['lastname']; ?></p>
            </div>
            <!-- final - user account -->
            <!-- first menu -->
            <ul class="navbar-nav d-flex f-column w-100">
              <?php foreach ($_SESSION['menu'] as $menu) {
                if ($menu['priority'] == 1) { ?>
                  <li class="<?= Menu::active($menu['controller'], $menu['action']) ?>">
                    <a href="<?= URL_BASE . $menu['url'] ?>"><span><i class="<?= $menu['icon'] ?>"></i></span><?= $menu['title'] ?></a>
                  </li>
              <?php }
              } ?>
            </ul>
            <!-- final - first menu -->
          </div>
        </section>
        <!-- main menu -->
        <section class="pd-t-1">
          <ul class="navbar-nav d-flex f-column">
            <?php foreach ($_SESSION['menu'] as $menu) {
              if ($menu['priority'] == 2) { ?>
                <li class="<?= Menu::active($menu['controller'], $menu['action']) ?>"><a href="<?= URL_BASE . $menu['url'] ?>"><span><i class="<?= $menu['icon'] ?>"></i></span><?= $menu['title'] ?></a></li>
            <?php }
            } ?>
          </ul>
        </section>
        <!-- final - main menu -->
      </div>
    </div>
    <div class="bg-navbar btn-navbar"></div>
  </nav>
</header>
