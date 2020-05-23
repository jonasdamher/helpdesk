<?php 

function autoload($class) {
    require_once('controllers/'.$class.'.php');
}

spl_autoload_register('autoload');

?>