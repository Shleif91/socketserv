<?php

namespace AppBundle\Server;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Notification implements MessageComponentInterface
{
    protected $connections = array();

    /**
     * A new websocket connection
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections[] = $conn;
        echo "New connection \n";
    }

    /**
     * Handle message sending
     *
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->connections as $connection) {
            $connection->send($msg);
        }
    }

    /**
     * A connection is closed
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        foreach($this->connections as $key => $conn_element){
            if($conn === $conn_element){
                unset($this->connections[$key]);
                break;
            }
        }
    }

    /**
     * Error handling
     *
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->send("Error : " . $e->getMessage());
        $conn->close();
    }
}