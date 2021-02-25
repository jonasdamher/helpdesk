<nav class="pd-t-2" role="navigation" aria-label="Tab menu">
	<ul class="navbar-nav navbar-horizontal navbar-light">
		<li><a class="<?= $_GET['action'] == 'details' ? 'active' : ''; ?>" href="<?= URL_BASE . $_GET['controller'] . '/details/' . $_GET['id'] ?>"><span><i class="fas fa-eye"></i></span>Ver Ficha</a>
		<li><a class="<?= $_GET['action'] == 'update' ? 'active' : ''; ?>" href="<?= URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'] ?>"><span><i class="fas fa-pen"></i></span>Actualizar</a>
	</ul>
</nav>