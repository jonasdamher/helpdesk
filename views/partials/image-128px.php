<?php if( Utils::imageCheck($dirImage) ) { ?>
<img class="shadow-sm img-128 border-rd-10 m-b-1" alt="<?= $titleImage ?>" src="<?= Utils::image($dirImage); ?>" title="<?= $titleImage ?>"/>
<?php }else { ?>
<div class="shadow-sm bg-gray text-white border-rd-10 m-b-1 img-128 d-flex j-content-center" title="<?= $titleImage ?>">
	<i class="fas fa-<?= $icon ?> fa-4x" data-fa-transform="shrink-7"></i>
</div>
<?php } ?>