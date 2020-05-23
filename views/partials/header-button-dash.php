<div class="d-flex j-between f-items-center">
	<div class="d-flex f-items-center">
		<?php include 'views/partials/button-navbar.php'; ?>
		<h1 class="h1 text-white"><?= $title ?></h1>
	</div>
	<a class="btn border-rd btn-rounded-xs btn-light shadow-lg" href="<?= url_base.$_GET['controller']?>/new" title="<?= $buttonName ?>"><span><i class="fas fa-plus"></i></span><span><?= $buttonName ?></span></a>
</div>