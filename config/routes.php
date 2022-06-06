<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
return static function (RouteBuilder $routes) {

    $routes->plugin(
        'ApiGateway',
        ['path' => '/api-gateway'],
        function (RouteBuilder $routes) {
            $routes->fallbacks(DashedRoute::class);
        }
    );
};
