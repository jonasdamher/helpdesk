<?php

declare(strict_types=1);

switch ($url) {
    case 'controller':
        $url = $_GET['controller'];
        break;
    case 'details':
        $url = $_GET['controller'] . '/details/' . $_GET['id'];
        break;
}
?>
<div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
        <div class="d-flex f-items-center">
            <a class="btn btn-text-light" href="<?= URL_BASE . $url ?>" title="Ir atrás"><i class="fas fa-arrow-left" data-fa-transform="grow-6"></i></a>
            <h1 class="h1 text-white"><?= $nameSection ?></h1>
        </div>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
        <?php include $form; ?>
        <?= $this->getResponseMessage(); ?>
    </section>
    <?php include 'views/includes/snackbar.php'; ?>
</div>