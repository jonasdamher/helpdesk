<?php
$countThead = (count($thead) - 1);
foreach ($thead as $key => $th) {
?>
	<?= ($countThead == $key) ? '<th colspan="2" scope="col">' : '<th scope="col">' ?>
	<?php if (array_key_exists('order', $th)) {
		$orderTable = 'order=' . $th['order'] . '&alt=' . $th['alt'];
	?>
		<div class="d-flex" title="Ordenar por <?= mb_strtolower((array_key_exists('title', $th) ? $th['title'] : $th['name'])) ?>">
			<a href="<?= Utils::linkParams($orderTable) ?>">
				<?= $th['name'] ?>
				<span class="text-blue"><i class="fas fa-<?= Utils::activeQueryIconOrder($orderTable) ?> fa-sm"></i></span>
			</a>
		</div>
	<?php } else { ?>
		<div class="d-flex">
			<?= $th['name'] ?>
		</div>
	<?php } ?>
	</th>
<?php } ?>