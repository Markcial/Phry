<?php

namespace Phry\Handlers;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampConnection;
use Ratchet\Wamp\WampServerInterface;

class PubSub implements WampServerInterface
{
    /** @var Topic[] */
    protected $topics = array();

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        if (!array_key_exists($topic->getId(), $this->topics)) {
            // no one is subscribed to that topic, warn about this
            //$conn->send('You are publishing to a topic that no one listens.');
            return;
        }
        $topic->broadcast($event);
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        /** @var WampConnection $wrapper */
        $wrapper = $conn;
        $wrapper->callError($id, $topic, 'RPC not supported on this demo');
        // error
    }

    // No need to anything, since WampServer adds and removes subscribers to Topics automatically
    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->topics[$topic->getId()]= $topic;
    }
    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
    }
    public function onOpen(ConnectionInterface $conn)
    {
    }
    public function onClose(ConnectionInterface $conn)
    {
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }
}
