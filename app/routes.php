<?php

$router->get('', 'PageController@index', ['auth' => true]);
$router->post('word', 'WordsController@store', ['auth' => true]);
$router->get('registration', 'UsersController@register');
$router->post('registration', 'UsersController@store');
$router->get('login', 'UsersController@loginView');
$router->post('login', 'UsersController@login');
$router->get('logout', 'UsersController@logout');