<?php

session_start();

require_once __DIR__ . '/app/core/Router.php';

$router = new Router();

if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') {
    header('Location: /produtos');
    exit;
}

require_once __DIR__ . '/routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
