<?php

declare(strict_types=1);

include 'views/includes/head.php';

if (Menu::check()) {
    include 'views/includes/nav.php';
}
?>
<main>
    <?php include 'views/' . View::controller() . '/' . View::action() . '.php'; ?>
</main>
<?php include 'views/includes/footer.php'; ?>