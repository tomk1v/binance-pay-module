<?php

namespace Internship\BinancePay\Observer;

class PaymentRefund implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $observer_data = $observer->getData('custom_text');

        return $this;
    }
}
