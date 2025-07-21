<?php

class Router {
    public function run() {
        $url = $_GET['url'] ?? 'produto/index';
        $url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

        $controller = ucfirst($url[0]) . 'Controller';
        $method = $url[1] ?? 'index';

        $controllerPath = '../app/controllers/' . $controller . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerInstance = new $controller;
            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
                return;
            }
        }

        http_response_code(404);
        echo "Página não encontrada";
    }
}
