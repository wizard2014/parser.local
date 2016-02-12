<?php

namespace Ebay\Service;

use PhpAmqpLib\Message\AMQPMessage;

interface FindItemsServiceInterface
{
    /**
     * Listener
     */
    public function listen();

    /**
     * @param AMQPMessage $msg
     */
    public function process(AMQPMessage $msg);

    /**
     * @param array $data
     * @param null  $appId
     *
     * @return array|\DTS\eBaySDK\Finding\Types\ErrorData[]|int
     */
    public function findItems(array $data, $appId = null);
}
