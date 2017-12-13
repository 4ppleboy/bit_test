<?php

class App
{
    /**
     * @var \DI\Container
     */
    private $container;

    public function __construct()
    {
        $this->boot();
    }

    public function getContainer()
    {
        return $this->container;
    }

    private function boot()
    {
        $builder = new DI\ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAnnotations(true);
        $this->container = $builder->build();

        $this->container->set('config', \DI\object('App\Backend\Config')->lazy());
        $this->container->set('db', \DI\object('App\Backend\DbConnection')->lazy());
        $this->container->set('router', \DI\object('App\Backend\Router'));
        $this->container->set('request', \DI\object('App\Backend\Request'));
    }

    public function handleRequest()
    {
        $router = $this->container->get('router');
        $router->resolve();
    }
}