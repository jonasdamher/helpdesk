<footer>
    <p>Versión <?= PROJECT_VERSION ?></p>
</footer>
<!--SCRIPTS-->
<script src="<?= URL_BASE ?>public/js/all.min.js" async></script>
<script src="<?= URL_BASE ?>public/js/material.js" async></script>
<script src="<?= URL_BASE ?>public/js/main.js" async></script>
<?php
$totalLinksJs = count(Footer::getLinksJs());
if ($totalLinksJs > 0) {
    foreach (Footer::getLinksJs() as $linkJs) { ?>
        <script src="<?= URL_BASE ?>public/js/<?= $linkJs ?>.js"></script>
<?php }
} ?>
<!--END SCRIPTS-->
</body>

</html>