<?php

namespace App\Core;

use Exception;

class Router
{
    public $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * @param $uri
     * @param $controller
     * @return mixed
     */
    public function get($uri, $controller, $options = [])
    {
        return $this->routes['GET'][$uri] = [
            'controller' => $controller,
            'options' => $options
        ];
    }

    /**
     * @param $uri
     * @param $controller
     * @return mixed
     */
    public function post($uri, $controller, $options = [])
    {
        return $this->routes['POST'][$uri] = [
            'controller' => $controller,
            'options' => $options
        ];
    }

    /**
     * @throws Exception
     */
    public function direct($uri, $type)
    {
        if (!array_key_exists($uri, $this->routes[$type])) {
            throw new Exception('No Route');
        }
            // todo: inject dependencies
        $this->checkAuthUser($type, $uri);

        $data = explode('@', $this->routes[$type][$uri]['controller']);

        return $this->callAction($data[0], $data[1]);
    }

    /**
     * @param $controller
     * @param $method
     * @return mixed
     * @throws Exception
     */
    private function callAction($controller, $method)
    {
        $controller = 'App\Controllers\\' . $controller;
        $controller = new $controller;

        if (!method_exists($controller, $method)) {
            throw new Exception("{$method} does not belong to {$controller}");
        }

        return $controller->$method();
    }

    private function checkAuthUser($type, $uri)
    {
        if (
            !empty($options = $this->routes[$type][$uri]['options']) &&
            isset($options['auth']) &&
            !authCheck()
        ) {
            redirect('login');
            exit;
        }
    }
}
