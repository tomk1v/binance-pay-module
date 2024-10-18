<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Queue\Order;

class CreationPublisher
{
    private const QUEUE_TOPIC = 'binance.order.creation';

    /**
     * Publisher constructor.
     *
     * @param \Magento\Framework\MessageQueue\PublisherInterface $publisher
     */
    public function __construct(
        protected \Magento\Framework\MessageQueue\PublisherInterface $publisher
    ) {
    }

    /**
     * Publishes the provided data to the queue topic.
     *
     * @param string $data
     * @return void
     */
    public function publish($data)
    {
        $this->publisher->publish(self::QUEUE_TOPIC, $data);
    }
}
