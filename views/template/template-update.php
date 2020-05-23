<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    <div class="dashboard-header bg-blue">
    
    </div>
    <div class="bg-white dashboard-content shadow-sm">
     
      <?= $this->getResponseMessage() ?>
    </div>
    <?php include 'views/partials/snackbar.php'; ?>
  </div>
</main>
<?php include 'views/partials/footer.php'; ?>