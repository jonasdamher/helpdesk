<form class="form w-100-sm" method="get" action="<?= Utils::linkParams('search') ?>">
	<div class="form-box-input pd-0">
		<button class="btn-icon icon" type="submit" title="Botón buscar"><i class="fas fa-search"></i></button>
		<label class="label text-bold" for="search" title="Buscar">Buscar</label>
		<input class="ipt" id="search" name="search" type="search" value="<?= Utils::getCheck('search') ?>" title="Buscar"/>
	</div>
</form>