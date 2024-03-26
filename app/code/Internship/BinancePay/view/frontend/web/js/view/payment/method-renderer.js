define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'binancepay',
                component: 'Internship_BinancePay/js/view/payment/method-renderer/binancepay'
            }
        );
        return Component.extend({});
    }
);
