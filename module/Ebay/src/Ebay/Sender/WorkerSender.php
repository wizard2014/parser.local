<?php

namespace Ebay\Sender;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class WorkerSender
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    }

    public function execute(array $params)
    {
        $channel = $this->connection->channel();

        $channel->queue_declare('queue', false, true, false, false);

        $msg = new AMQPMessage(
            json_encode($params),
            ['delivery_mode' => 2]
        );

        $channel->basic_publish($msg, '', 'queue');

        $channel->close();
        $this->connection->close();
    }
}
