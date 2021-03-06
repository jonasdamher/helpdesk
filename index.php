<?php

declare(strict_types=1);

session_start();

require_once 'libs/Environment.php';
Environment::init();
require_once 'config/Globals.php';
error_reporting(ERROR_REPORTING);

require_once 'helpers/Utils.php';
require_once 'libs/Auth.php';
require_once 'core/DatabaseHandler.php';
require_once 'core/Database.php';
require_once 'libs/ResponseHandler.php';
require_once 'libs/Validator.php';
require_once 'core/BaseModel.php';
require_once 'core/BaseController.php';
require_once 'libs/Router.php';
