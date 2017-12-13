<?php

namespace App\Backend;

use AltoRouter;
use DI\Container;

class Request
{
    protected $namespace = 'App\\Backend\\';
    protected $controller;
    protected $action;
    protected $params;

    protected $container;
    protected $altoRouter;

    public function __construct(Container $container, AltoRouter $altoRouter)
    {
        $this->container = $container;
        $this->altoRouter = $altoRouter;
    }

    public function forward()
    {
        $this->container->set($this->controller, \DI\object($this->namespace . $this->controller));

        $controller = $this->container->get($this->controller);
        $methods = get_class_methods($controller);
        if (in_array($this->action, $methods)) {
            $controller->{$this->action}($this);
        } else {
            //Change to logger, add forward on error page
            die('Undefined action: ' . $this->action);
        }
    }

    public function createUrl(string $name, array $params = [])
    {
        return $this->altoRouter->generate($name, $params);
    }

    public function __get(string $name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }

        return null;
    }

    public function __isset(string $name)
    {
        if (in_array($name, ['action', 'controller', 'params'])) {
            return true;
        }

        return false;
    }

    public function __set(string $name, $value)
    {
        if ($name === 'action') {
            $this->action = 'action' . ucfirst($value);
        }

        if ($name === 'controller') {
            $this->controller = ucfirst($value) . 'Controller';
        }

        if ($name === 'params') {
            $this->params = $value;
        }
    }
}