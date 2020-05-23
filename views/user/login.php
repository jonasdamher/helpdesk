<?php include 'views/partials/head.php'; ?>
<main>
  <div class="container f-column">
    
    <section class="dashboard-header bg-blue d-flex j-content-center">
      <h1 class="h1 text-white">Helpdesk 2.0</h1>
    </section>

    <section class="dashboard-content d-flex j-content-center pd-0 f-column f-items-center pd-0-xs">
      <div class="bg-white shadow-sm w-100-xs">
        <div class="card-body">
          <form id="login" class="form" action="<?= url_base ?>Login/index" method="post">
            <div class="form-box-input">
              <span class="icon"><i class="fas fa-envelope"></i></span>
              <label class="label" for="email">Correo electrónico</label>
              <input class="ipt ipt-default" id="email" name="email" type="email" value="<?= Utils::postCheck('email') ?>" required/>
            </div>

            <div class="form-box-input">
              <span class="icon"><i class="fas fa-lock"></i></span>
              <label class="label" for="password">Contraseña</label>
              <input class="ipt ipt-default" id="password" name="password" type="password" value="<?= Utils::postCheck('password') ?>" autocomplete="off" required/>
              <button class="btn btn-icon btn-view-pass" title="Mostrar contraseña" type="button" tabindex="-1"><i class="fas fa-eye-slash"></i></button>
            </div>
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
            <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-start" type="submit">Iniciar sesión</button>
          </form>
        </div>
      </div>
      <div class="text-sm pd-t-1 w-100-xs">
        <p>This site is protected by reCAPTCHA and the Google</p>
        <a href="https://policies.google.com/privacy" rel="noopener" target="_blank">Privacy Policy</a> and
        <a href="https://policies.google.com/terms" rel="noopener" target="_blank">Terms of Service</a> apply.
      </div>
      <?= $this->getResponseMessage(); ?>
    </section>

  </div>
</main>
<script>
function onloadCallback(){
grecaptcha.ready(function () {
  grecaptcha.execute('<?= $_ENV['SITE_KEY'] ?>', { action: 'index' }).then(function (token) {
    $('#recaptchaResponse').val(token);
  });
});
}
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=<?= $_ENV['SITE_KEY'] ?>" async defer></script>
<?php include 'views/partials/footer.php'; ?>