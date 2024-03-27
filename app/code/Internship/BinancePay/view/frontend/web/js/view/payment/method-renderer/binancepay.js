define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default'
    ],
    function (
        $,
        Component
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Internship_BinancePay/payment/binancetemplate'
            },

            beforePlaceOrder: function () {
                $.ajax({
                    url: '/binancepay/checkout/init',
                    showLoader: true,
                    data: {
                        quoteData: window.checkoutConfig.quoteData,
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function (response) {
                        if (response.success) {
                            window.location.href = response.checkoutUrl;
                        } else {
                            console.error('Error occurred:', response);
                            alert('An error occurred. Please try again later.');
                        }                    }
                });
            },

            /**
             * Place order.
             */
            placeOrder: function (data, event) {
                // var self = this;
                //
                // if (event) {
                //     event.preventDefault();
                // }
                //
                // if (this.validate() &&
                //     additionalValidators.validate() &&
                //     this.isPlaceOrderActionAllowed() === true
                // ) {
                    this.beforePlaceOrder();
                    // this.isPlaceOrderActionAllowed(false);
                    //
                    // this.getPlaceOrderDeferredObject()
                    //     .done(
                    //         function () {
                    //             self.afterPlaceOrder();
                    //
                    //             if (self.redirectAfterPlaceOrder) {
                    //                 redirectOnSuccessAction.execute();
                    //             }
                    //         }
                    //     ).always(
                    //     function () {
                    //         self.isPlaceOrderActionAllowed(true);
                    //     }
                    // );
                    //
                    // return true;
                // }

                return false;
            },
        });
    }
);
