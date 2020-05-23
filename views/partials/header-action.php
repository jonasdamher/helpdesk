<?php 

switch ($url) {
	case 'controller':
		$url = $_GET['controller'];
	break;
	case 'details':
		$url = $_GET['controller'].'/details/'.$_GET['id'];
	break;
}

?>

<div class="d-flex f-items-center">
	<a class="btn btn-text-light" href="<?= url_base.$url ?>" title="Ir atrás"><i class="fas fa-arrow-left" data-fa-transform="grow-6"></i></a>
	<h1 class="h1 text-white"><?= $nameSection ?></h1>
</div>