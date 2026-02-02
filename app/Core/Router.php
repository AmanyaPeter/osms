<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function add($method, $uri, $controller) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function dispatch($requestedUri, $requestedMethod) {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $requestedUri && $route['method'] === $requestedMethod) {
                $this->callAction($route['controller']);
                return;
            }
        }

        // Simple dynamic route matching for /student/edit/1
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9]+\}/', '([a-zA-Z0-9]+)', $route['uri']);
            $pattern = str_replace('/', '\/', $pattern);
            if (preg_match('/^' . $pattern . '$/', $requestedUri, $matches) && $route['method'] === $requestedMethod) {
                array_shift($matches);
                $this->callAction($route['controller'], $matches);
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }

    protected function callAction($controller, $params = []) {
        list($class, $method) = explode('@', $controller);
        $class = "App\\Controllers\\{$class}";
        $instance = new $class;
        call_user_func_array([$instance, $method], $params);
    }
}
