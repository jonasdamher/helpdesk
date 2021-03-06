<?php

declare(strict_types=1);

/**
 * Definición de variables globales
 */
// URL absoluta del proyecto. 
define('URL_BASE', 'https://' . $_SERVER['SERVER_NAME'] . '/');
// Nombre del proyecto.
define('PROJECT_NAME', Environment::process('PROJECT_NAME'));
// Versión del proyecto.
define('PROJECT_VERSION', Environment::process('PROJECT_VERSION'));
// Versión de api.
define('API_VERSION', Environment::process('API_VERSION'));
//Nivel de notificaciones de error.
define('ERROR_REPORTING', Environment::process('ERROR_REPORTING'));
// Formatos de imagen admitidos
define('ALLOW_IMAGES', 'image/x-png,image/jpg,image/jpeg');
