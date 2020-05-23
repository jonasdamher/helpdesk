<?php include 'views/partials/head.php'; ?>
<main>
  <div class="container f-column">
    <section class="dashboard-header bg-blue d-flex j-content-center">
      <h1 class="h1 text-white">Helpdesk 2.0</h1>
    </section>
    <section class="dashboard-content d-flex j-content-center pd-0">
      <div class="bg-white shadow-sm">
        <div class="card-body">
          <h2 class="h1 pd-b-2"><?= $message ?></h2>
          <a class="btn border-rd btn-dark shadow-sm" href="<?= url_base ?>" >Regresar</a>
        </div>
      </div>
    </section>
  </div>
</main>
<?php include 'views/partials/footer.php'; ?>