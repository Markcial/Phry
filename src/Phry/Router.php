<?php

namespace Phry;

use Ratchet\Http\Router as BaseRouter;
use Ratchet\MessageComponentInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router extends BaseRouter
{
    /** @var RouteCollection */
    protected $routes;
    /** @var string */
    protected $httpHost;
    /** @var RequestContext */
    protected $context;

    public function __construct($host, RouteCollection $routes = null)
    {
        $this->httpHost = $host;
        if (is_null($routes)) {
            $routes = new RouteCollection();
        }
        $this->context = new RequestContext();
        $this->routes = $routes;
        $this->updateMatcher();
    }

    protected function updateMatcher()
    {
        $this->_matcher = new UrlMatcher($this->routes, $this->context);
    }

    public function route($path, MessageComponentInterface $component)
    {
        $name = str_replace('/', '_', $path);
        $this->routes->add(
            $name,
            new Route(
                $path,
                array('_controller' => $component),
                array('Origin' => $this->httpHost),
                array(),
                $this->httpHost
            )
        );
        $this->updateMatcher();
    }
}
