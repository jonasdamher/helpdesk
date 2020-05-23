<nav class="pagination  d-flex j-content-end" role="navigation" aria-label="Pagination">
	<ul>
	<?php 
	$countPagination = count($pagination)-1;
	foreach ($pagination as $key => $item) { ?>
		<li class="<?= $item['status'] ?>" title="Página <?= $item['page']?>">
			<a href="<?= $item['status'] == 'disabled' ? '#' : Utils::linkPagination($item['page']) ?>" <?= $item['status'] == 'active' ? 'aria-current="true"' : '' ?> aria-label="Página <?= $item['status'] == 'active' ? 'actual, página '.$item['page'] : $item['page'] ?>" <?= (($countPagination == $key) ? ' rel="next"' : '')?> <?= (($key == 0) ? ' rel="prev"' : '') ?>><?= $item['page'] ?></a>
		</li>
	<?php } ?>
	</ul>
</nav>