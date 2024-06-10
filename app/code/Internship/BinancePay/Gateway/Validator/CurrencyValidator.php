<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */
namespace Internship\BinancePay\Gateway\Validator;

use Magento\Framework\Exception\NotFoundException;

class CurrencyValidator extends \Magento\Payment\Gateway\Validator\AbstractValidator
{
    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Payment\Gateway\Validator\ResultInterfaceFactory $resultFactory
     */
    public function __construct(
        protected \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Payment\Gateway\Validator\ResultInterfaceFactory $resultFactory,
    ) {
        parent::__construct($resultFactory);
    }

    /**
     * Validate country
     *
     * @param array $validationSubject
     * @return \Magento\Payment\Gateway\Validator\ResultInterface
     * @throws \Exception
     */
    public function validate(array $validationSubject)
    {
        $isValid = ($validationSubject['currency'] === 'USD');
        return $this->createResult($isValid);
    }
}
