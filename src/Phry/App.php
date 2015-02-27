<?php

namespace Phry;

use Ratchet\Http\HttpServer;
use Ratchet\MessageComponentInterface;
use Ratchet\Server\IoServer;
use React\Socket\Server as Reactor;
use React\EventLoop\Factory as LoopFactory;

class App
{
    /** @var string */
    protected $host;
    /** @var int */
    protected $port;

    /** @var Router */
    protected $router;

    public function __construct($host = '127.0.0.1', $port = 1337)
    {
        $this->router = new Router($host);
        $this->host = $host;
        $this->port = $port;
    }

    public function route($path, MessageComponentInterface $handler)
    {
        $this->router->route($path, $handler);
    }

    public function run()
    {
        $loop = LoopFactory::create();
        $socket = new Reactor($loop);
        $socket->listen($this->port, $this->host);
        $engine = new IoServer(new HttpServer($this->router), $socket, $loop);
        $engine->run();
    }
}
