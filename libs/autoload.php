<?php

declare(strict_types=1);

define('PATH_CLASS', $path);

function autoloadClass($className)
{
    require_once(PATH_CLASS . $className . '.php');
}

spl_autoload_register('autoloadClass');
