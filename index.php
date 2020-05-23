<?php 
session_start();

require_once 'config/Globals.php';
require_once 'libs/Dotenv.php';

$dotenv = new DotEnv('.env');
$env = $dotenv->env();

$_ENV['SITE_KEY'] = $env['SITE_KEY'];
$_ENV['SECRET_KEY'] = $env['SECRET_KEY'];
$_ENV['PLACE_KEY'] = $env['PLACE_KEY'];

require_once 'libs/Utils.php';
require_once 'libs/ErrorHandler.php';
require_once 'libs/autoload.php';
require_once 'libs/Router.php';

$router = new Router();

?>