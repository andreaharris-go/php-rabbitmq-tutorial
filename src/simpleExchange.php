<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

function simpleExchange()
{
    $orderData = [
        'order_id' => 1,
        'title' => 'order one',
    ];
    $exchange = 'page_view_exchange';
    $connection = new AMQPStreamConnection(
        $_ENV['RABBIT_HOST'],
        $_ENV['PORT'],
        $_ENV['USERNAME'],
        $_ENV['PASSWORD'],
        $_ENV['VHOST'],
    );
    $channel = $connection->channel();
    $channel->exchange_declare(
        $exchange,
        AMQPExchangeType::TOPIC,
        false,
        false,
        false
    );
    $msg = new AMQPMessage(
        json_encode($orderData)
    );
    $channel->basic_publish($msg, $exchange);
    $channel->close();
    $connection->close();
}