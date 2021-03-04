<div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
        <div class="d-flex j-between f-items-center">
            <div class="d-flex f-items-center">
                <button type="button" class="btn btn-text-light m-r-1 btn-navbar" title="Menu" aria-label="Menu"><i class="fas fa-bars" data-fa-transform="grow-12"></i></button>
                <h1 class="h1 text-white"><?= Utils::getSection() ?></h1>
            </div>
            <a class="btn border-rd btn-rounded-xs btn-light shadow-lg" href="<?= URL_BASE . View::controller() ?>/new" title="Añadir"><span><i class="fas fa-plus"></i></span><span>Añadir</span></a>
        </div>
    </section>
    <section class="bg-white dashboard-content shadow-sm">
        <?php if ($table['valid']) { ?>
            <div class="d-flex j-between f-items-end pd-b-1">
                <div class="d-flex f-items-end w-100-sm">
                    <?php include 'views/includes/search.php'; ?>
                    <?php include 'views/includes/dropdown-filter.php'; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <?php include 'views/' . View::controller() . '/table.php'; ?>
                </table>
            </div>
            <div class="d-flex j-content-end pd-t-1">
                <?php include 'views/includes/pagination.php'; ?>
            </div>
        <?php } else { ?>
            <p>no hay nada.</p>
        <?php } ?>
    </section>
</div>