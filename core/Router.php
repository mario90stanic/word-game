<?php declare(strict_types=1);

namespace App\Core;

use App\Container\Exceptions\ContainerException;
use App\Helpers\EnglishDictionary;
use App\Interfaces\DictionaryInterface;
use App\Interfaces\PlayerInterface;
use App\Models\Player;
use App\Container\Container;
use Exception;

class Router
{
    public array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $container->set(DictionaryInterface::class, EnglishDictionary::class);
        $container->set(PlayerInterface::class, Player::class);
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param array $options
     */
    public function get(string $uri, string $controller, array $options = [])
    {
        $this->routes['GET'][$uri] = [
            'controller' => $controller,
            'options' => $options,
        ];
    }

    /**
     * @param $uri
     * @param $controller
     */
    public function post($uri, $controller, $options = [])
    {
        $this->routes['POST'][$uri] = [
            'controller' => $controller,
            'options' => $options,
        ];
    }

    /**
     * @throws Exception
     */
    public function direct(string $uri, string $type)
    {
        if (!array_key_exists($uri, $this->routes[$type])) {
            // todo: create 404 page
            http_response_code(404);
            die;
        }

        $this->checkAuthUser($type, $uri);
        $data = explode('@', $this->routes[$type][$uri]['controller']);

        return $this->callAction($data[0], $data[1]);
    }

    /**
     * @param string $controller
     * @param string $method
     * @return mixed
     * @throws ContainerException
     */
    private function callAction(string $controller, string $method): mixed
    {
        $controller = 'App\Controllers\\' . $controller;
        $controller = $this->container->get($controller);

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
