<?php declare(strict_types=1);

use App\Container\Container;
use App\Core\Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    /**
     * @test
     */
    public function checkIfRouterIsGettingData()
    {
        $container = new Container();
        $router = new Router($container);
        $router->get('registration', 'UsersController@register');

        $this->assertArrayHasKey('GET', $router->routes);
        $this->assertArrayHasKey('registration', $router->routes['GET']);
        $this->assertArrayHasKey('controller', $router->routes['GET']['registration']);
        $this->assertArrayHasKey('options', $router->routes['GET']['registration']);
    }

    /**
     * @test
     */
    public function checkIfRouterIsPostingData()
    {
        $container = new Container();
        $router = new Router($container);
        $router->post('registration', 'UsersController@store');

        $this->assertArrayHasKey('POST', $router->routes);
        $this->assertArrayHasKey('registration', $router->routes['POST']);
        $this->assertArrayHasKey('controller', $router->routes['POST']['registration']);
        $this->assertArrayHasKey('options', $router->routes['POST']['registration']);
    }
}