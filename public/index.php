<?php
require_once '../app/core/Router.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Helpers.php';
require_once '../app/core/Session.php';

$router = new Router();
$router->run();