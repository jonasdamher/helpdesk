<?php include 'views/partials/head.php'; ?>
<?php include 'views/partials/nav.php'; ?>
<main>
  <div class="container container-dashboard f-column">
    
    <section class="dashboard-header dashboard-tab bg-blue d-flex f-column">
      <?php 
      $url = 'controller';
      $nameSection = 'Ficha de Incidencia';
      include 'views/partials/header-action.php'; 
      include 'views/partials/tab.php'; ?>
    </section>

    <section class="bg-white dashboard-content shadow-sm">
     
      <div class="d-flex j-evenly f-wrap j-content-start-sm">
        <div class="pd-b-1">
        <p class="p">#<?= $incidence['_id'] ?></p>
        <p class="p">Asunto de incidencia: <?= $incidence['subject'] ?></p>
        <p class="p">Descripción: <?= $incidence['description'] ?></p>
        <p class="p">Pertenece al Pto: <?= $incidence['point_of_sale'] ?></p>
        <p class="p">Código de pto: <?= $incidence['company_code'] ?></p>
        <p class="p">Creada por <?= $incidence['name_created'].' '.$incidence['lastname_created'] ?></p>
        <p class="p">Asignada a <?= $incidence['name_attended'].' '. $incidence['lastname_attended'] ?></p>
        <p class="p">Prioridad <?= $incidence['priority'] ?></p>
        <p class="p">Estado de incidencia: <?= $incidence['status'] ?></p>
        <p class="p">Tipo de incidencia: <?= $incidence['type'] ?></p>
        <p><?= $incidence['finish_date'] ?></p>
        </div>
        <div class="pd-b-1">
          <p class="p text-bold">Artículos recogidos</p>
          <p>
          <?php if($countArticles > 0) { 
          foreach ($articles as $key => $article) { ?>
            <p class="p"><?= $article['name'] ?></p>
          <?php } 
          }else{ ?>
            <p class="p"><?= 'Ninguno' ?></p>
          <?php } ?>
          </p>
          <p class="p text-bold">Artículos en prestamo</p>
          <?php if($countArticlesBorrowed > 0) { 
            foreach ($articlesBorrowed as $key => $article) { ?>
            <p class="p"><?= $article['name'].'/ nº de serie '.$article['serial'] ?></p>           
          <?php }
          }else{ ?>
          <p class="p"><?= 'Ninguno' ?></p>
          <?php } ?>
        </div>
      </div>
      <div class="d-flex j-between f-items-end pd-b-1">
        <div class="d-flex j-content-end">
          <a class="btn btn-dark border-rd shadow-lg m-r-1" href="<?= url_base.$_GET['controller'].'/collected/'.$_GET['id'] ?>">Lista de artículos recogidos</a>
          <a class="btn btn-dark border-rd shadow-lg" href="<?= url_base.$_GET['controller'].'/borrowed/'.$_GET['id'] ?>">Lista de artículos en prestamo</a>
        </div>
      </div>
    </section>
  </div>
</main>
<?php include 'views/partials/footer.php'; ?>