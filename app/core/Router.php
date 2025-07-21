<?php

class Router
{
    protected $routes = [];

    // Registrar rota GET
    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    // Registrar rota POST
    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    // Disparar rota conforme URL e método HTTP
    public function dispatch($uri, $method)
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];

            // Espera formato "Controller@metodo"
            if (is_string($handler)) {
                [$controllerName, $methodName] = explode('@', $handler);

                $controllerFile = __DIR__ . "/../controllers/{$controllerName}.php";

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    if (class_exists($controllerName)) {
                        $controller = new $controllerName();

                        if (method_exists($controller, $methodName)) {
                            $controller->$methodName();
                            return;
                        }
                    }
                }
                http_response_code(500);
                echo "Erro ao chamar controlador ou método.";
                return;
            }

            // Pode implementar handlers por closures futuramente
        }

        // Rota não encontrada
        http_response_code(404);
        echo "Página não encontrada";
    }
}
