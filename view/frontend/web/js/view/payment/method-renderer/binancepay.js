<!--
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */
-->
define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magento_Customer/js/customer-data'
    ],
    function (
        ko,
        $,
        Component,
        quote,
        additionalValidators,
        customerData
    ) {
        'use strict';

        return Component.extend({
            isPlaceOrderActionAllowed: ko.observable(quote.billingAddress() != null),
            defaults: {
                template: 'Internship_BinancePay/payment/binancetemplate'
            },

            /**
             * Place order.
             */
            placeOrder: function (data, event) {
                if (event) {
                    event.preventDefault();
                }

                if (this.validate() &&
                    additionalValidators.validate() &&
                    this.isPlaceOrderActionAllowed() === true
                ) {
                    this.isPlaceOrderActionAllowed(false);

                    $.ajax({
                        url: '/binancepay/checkout/init',
                        showLoader: true,
                        type: 'GET',
                        success: function (response) {
                            if (response.success) {
                                window.location.href = response.checkoutUrl;
                            } else {
                                console.error('Error occurred:', response);
                                alert('An error occurred. Please try again later.');
                            }
                        }
                    });

                    return true;
                }

                return false;
            },
        });
    }
);
