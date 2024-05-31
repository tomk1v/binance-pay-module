define([
    'Magento_Customer/js/customer-data'
], function (customerData) {
    return function () {
        const sections = ['cart'];
        customerData.invalidate(sections);
        customerData.reload(sections, true);
    }
});
