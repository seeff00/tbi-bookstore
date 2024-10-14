<?php

namespace Api;

use Api\Controller\HTTPRequest;
use Exception;

class Router
{
    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * Creates HTTP GET route handler.
     *
     * @param $route
     * @param $controller
     * @param $action
     * @return void
     */
    public function get($route, $controller, $action): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'GET'){
            return;
        }

        $this->routes[$route] = ['controller' => $controller, 'action' => $action, 'request' => new HTTPRequest($_GET)];
    }

    /**
     * Creates HTTP POST route handler.
     *
     * @param $route
     * @param $controller
     * @param $action
     * @return void
     */
    public function post($route, $controller, $action): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'POST'){
            return;
        }

        $this->routes[$route] = ['controller' => $controller, 'action' => $action, 'request' => new HTTPRequest($_POST)];
    }

    /**
     * Creates HTTP PUT route handler.
     *
     * @param $route
     * @param $controller
     * @param $action
     * @return void
     */
    public function put($route, $controller, $action): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'PUT'){
            return;
        }

        parse_str(file_get_contents("php://input"),$put);
        $this->routes[$route] = ['controller' => $controller, 'action' => $action, 'request' => new HTTPRequest($put)];
    }

    /**
     * Creates HTTP DELETE route handler
     * @param $route
     * @param $controller
     * @param $action
     * @return void
     */
    public function delete($route, $controller, $action): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'DELETE'){
            return;
        }

        parse_str(file_get_contents('php://input'),$delete);
        $this->routes[$route] = ['controller' => $controller, 'action' => $action, 'request' => new HTTPRequest($delete)];
    }

    /**
     * Dispatch registered routes and handles unregistered.
     *
     * @throws Exception
     */
    public function dispatch($uri): void
    {
        if (array_key_exists($uri, $this->routes)) {
            $controller = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];
            $request = $this->routes[$uri]['request'];

            $controller = new $controller();
            $controller->$action($request);
        } else {
            throw new Exception("No route found for URI: $uri");
        }
    }
}