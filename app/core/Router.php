<?php

class Router {
    public function run() {
        $controllerName = $_GET['c'] ?? 'produto';
        $method = $_GET['m'] ?? 'index';

        $controllerClass = ucfirst($controllerName).'Controller';
        $controllerFile = "../app/controllers/{$controllerClass}.php";

        if(file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerClass();

            if(method_exists($controller, $method)) {
                $controller->$method();
            } else {
                echo "Método $method não encontrado.";
            }
        } else {
            echo "Controller $controllerClass não encontrado.";
        }
    }
}
