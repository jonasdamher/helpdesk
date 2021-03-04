<div class="d-flex j-content-end">
	<div class="dropdown">
		<button class="btn btn-dropdown" title="Acción <?= $linkTable['title'] ?>"><i class="fas fa-ellipsis-v"></i></button>
		<div class="dropdown-list shadow-lg d-none">
			<ul class="d-flex">
				<?php foreach ($linkTable['links'] as $link) { ?>
					<li><a href="<?= URL_BASE . $_GET['controller'] . $link['url'] ?>" class="link" title="<?= $link['name'] . ' ' . $linkTable['title'] ?>"><i class="fas fa-<?= $link['icon'] ?> fa-1x"></i></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>