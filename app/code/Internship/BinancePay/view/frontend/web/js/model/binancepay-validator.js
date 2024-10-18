define(
    ['mage/translate', 'Magento_Ui/js/model/messageList', 'Magento_Checkout/js/model/quote'],
    function ($t, messageList, quote) {
        'use strict';
        return {
            validate: function () {
                console.log('---------------');
                console.log(quote);
                console.log('---------------');
                console.log(quote.totals());
                console.log('---------------');
                console.log(quote.totals().base_currency_code);
                const currencyCode = quote.totals().base_currency_code;

                if (currencyCode !== 'USD') {
                    messageList.addErrorMessage({ message: $t('This payment method is only available for USD currency.') });
                    return false;
                }

                return true;
            }
        };
    }
);
