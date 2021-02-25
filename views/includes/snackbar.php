<?php if ($this->updateStatus()) { ?>
	<div class="snackbar snackbar-dark">
		<div class="snackbar-body">
			<span class="snackbar-message"><?= $this->getResponseMessage(); ?></span>
			<button class="btn btn-snackbar m-l-1"><i class="fas fa-times fa-lg"></i></button>
		</div>
	</div>
<?php } ?>