define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Internship_BinancePay/js/model/binancepay-validator'
    ],
    function (Component, additionalValidators, binancepayValidator) {
        'use strict';
        additionalValidators.registerValidator(binancepayValidator);
        return Component.extend({});
    }
);
