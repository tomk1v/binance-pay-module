<?php

namespace Internship\BinancePay\Model;

class OrderCreationPublisher
{
    private const QUEUE_TOPIC = 'binance.order.creation';

    public function __construct(
        protected \Magento\Framework\MessageQueue\PublisherInterface $publisher
    )
    {
    }

    public function publish($data)
    {
        $this->publisher->publish(self::QUEUE_TOPIC, $data);
    }
}
