<!DOCTYPE html>
<html lang="<?= Head::getLang() ?>">

<head>
    <title><?= Head::getTitle() . PROJECT_NAME ?></title>
    <!-- META -->
    <meta name="description" content="<?= Head::getDescription() ?>" />
    <meta name="keywords" content="<?= Head::getKeyWords() ?>" />
    <meta name="robots" content="<?= Head::getRobots() ?>" />
    <meta name="googlebot" content="<?= Head::getRobots() ?>" />
    <!-- META Open Graph -->
    <meta name="og:title" content="<?= Head::getTitle() . PROJECT_NAME ?>" />
    <meta name="og:description" content="<?= Head::getDescription() ?>" />
    <meta name="og:image" content="<?= URL_BASE ?>public/images/logo/launcher-3.png" />
    <meta name="og:url" content="<?= URL_BASE . View::controller() . Head::getCaconical() ?>" />
    <meta name="og:site_name" content="<?= PROJECT_NAME ?>" />
    <meta name="og:email" content="jonas.damher@gmail.com" />
    <meta name="og:type" content="blog" />
    <!-- META Twitter Cards -->
    <meta name="twitter:title" content="<?= Head::getTitle() . PROJECT_NAME ?>" />
    <meta name="twitter:description" content="<?= Head::getDescription() ?>" />
    <meta name="twitter:image" content="<?= URL_BASE ?>public/images/logo/launcher-3.png" />
    <meta name="twitter:site" content="@helpdesk" />
    <meta name="twitter:creator" content="@helpdesk" />
    <!-- META OTHERS -->
    <meta name="theme-color" content="#2855d1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#2855d1" />
    <meta name="apple-mobile-web-app-title" content="<?= Head::getTitle() . PROJECT_NAME ?>" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- OTHERS LINKS -->
    <link rel="canonical" href="<?= URL_BASE . View::controller() . Head::getCaconical() ?>" />
    <!-- ICONS -->
    <link rel="shortcut icon" type="image/ico" href="<?= URL_BASE ?>public/images/logo/favicon.ico" />
    <link rel="apple-touch-icon" type="image/png" href="<?= URL_BASE ?>public/images/logo/launcher-3.png" />
    <!-- MANIFEST -->
    <link rel="manifest" href="<?= URL_BASE ?>manifest.json" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= URL_BASE ?>public/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?= URL_BASE ?>public/css/all.min.css" />
    <?php
    $totalLinksCss = count(Head::getLinksCss());
    if ($totalLinksCss > 0) {
        foreach (Head::getLinksCss() as $linkCss) { ?>
            <link rel="stylesheet" type="text/css" href="<?= URL_BASE ?>public/css/<?= $linkCss ?>.css" />
    <?php }
    } ?>
    <!-- SCRIPTS JS -->
    <script src="<?= URL_BASE ?>public/js/jquery-3.5.1.min.js"></script>
    <?php
    $totalLinksJs = count(Head::getLinksJs());
    if ($totalLinksJs > 0) {
        foreach (Head::getLinksJs() as $linkJs) { ?>
            <script src="<?= URL_BASE ?>public/js/<?= $linkJs ?>.js"></script>
    <?php }
    } ?>
    <script src="<?= URL_BASE ?>public/js/service-worker.js"></script>
</head>

<body>