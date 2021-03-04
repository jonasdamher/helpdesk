<?php if (isset($linksFilter)) { ?>
	<div class="dropdown">
		<button class="btn btn-dropdown" title="Filtrar búsqueda" aria-label="Filtrar búsqueda"><i class="fas fa-sliders-h"></i></button>
		<div class="dropdown-list dropdown-min shadow-lg d-none">
			<ul>
				<?php foreach ($linksFilter as $key => $li) { ?>
					<li class="text-bold"><?= $key ?></li>
					<?php foreach ($linksFilter[$key] as $link) {
						$linkFilter = 'filter=' . $link['filter'] . '&to=' . $link['to']; ?>
						<li class="<?= Utils::activeQueryParam($linkFilter) ?>"><a href="<?= Utils::linkParams($linkFilter) ?>" title="Filtrar por <?= strtolower($link['name']) ?>"><?= $link['name'] ?></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
	</div>
<?php } ?>