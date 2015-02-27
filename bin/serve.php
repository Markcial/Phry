#!/usr/bin/env php
<?php

require_once './vendor/autoload.php';

$app = new \Phry\App();

$app->route('/pubsub', new \Ratchet\WebSocket\WsServer(new \Ratchet\Wamp\WampServer(new \Phry\Handlers\PubSub())));
$app->route('/websocket', new \Ratchet\WebSocket\WsServer(new \Phry\Handlers\WebSocket()));
$app->route('/rest', new \Phry\Handlers\Rest());
$app->route('/dashboard', new \Phry\Handlers\Dashboard());

$app->run();