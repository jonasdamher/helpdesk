<div class="container container-dashboard f-column">
    <section class="dashboard-header dashboard-tab bg-blue d-flex f-column">
        <div class="d-flex f-items-center">
            <a class="btn btn-text-light" href="<?= URL_BASE . $_GET['controller']  ?>" title="Ir atrás"><i class="fas fa-arrow-left" data-fa-transform="grow-6"></i></a>
            <h1 class="h1 text-white"><?= $nameSection ?></h1>
        </div>
        <nav class="pd-t-2" role="navigation" aria-label="Tab menu">
            <ul class="navbar-nav navbar-horizontal navbar-light">
                <li><a class="<?= $_GET['action'] == 'details' ? 'active' : ''; ?>" href="<?= URL_BASE . $_GET['controller'] . '/details/' . $_GET['id'] ?>"><span><i class="fas fa-eye"></i></span>Ver Ficha</a>
                <li><a class="<?= $_GET['action'] == 'update' ? 'active' : ''; ?>" href="<?= URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'] ?>"><span><i class="fas fa-pen"></i></span>Actualizar</a>
            </ul>
        </nav>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
        <?php include $section; ?>
        <?= $this->getResponseMessage(); ?>
    </section>
    <?php include 'views/includes/snackbar.php'; ?>
</div>