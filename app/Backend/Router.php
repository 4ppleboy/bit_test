<?php

namespace App\Backend;

use AltoRouter;
use DI\Container;

class Router
{
    private $altoRouter;
    private $container;

    public function __construct(Container $container, AltoRouter $altoRouter)
    {
        try {
            $altoRouter->addRoutes($this->routes());
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $this->altoRouter = $altoRouter;
        $this->container = $container;
    }

    private function routes()
    {
        return [
            ['GET', '/', function () {
                $this->buildRequest('site', 'index');
            }, 'home'],
            ['GET', '/index.php', function () {
                header('Location: ' . BASE_URL, true, 301);
                exit();
            }],
            ['GET', '/php/', function () {
                $this->buildRequest('site', 'phpInfo');
            }, 'php_info'],
            ['GET', '/error/', function () {
                $this->buildRequest('site', 'error');
            }, 'error'],
//            ['GET', '/test/[i:id]/', function ($id, $test = null) {
//                $this->buildRequest('site', 'test', ['id' => $id, 'test' => $test]);
//            }, 'test'],
            ['GET', '*', function () {
                header('Location: ' . BASE_URL . $this->altoRouter->generate('error'), true, 301);
                exit();
            }],
        ];
    }

    public function resolve()
    {
        $match = $this->altoRouter->match();
        if (false !== $match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);

            $request = $this->container->get('request');
            $request->forward();
        }
    }

    private function buildRequest(string $controller, string $action, array $params = [])
    {
        $request = $this->container->get('request');
        $request->controller = $controller;
        $request->action = $action;
        $request->params = $params;
    }
}