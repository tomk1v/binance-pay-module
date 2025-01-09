<!--
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2025 Tomkiv
 */
-->
define([
    'Magento_Customer/js/customer-data'
], function (customerData) {
    return function () {
        const sections = ['cart'];
        customerData.invalidate(sections);
        customerData.reload(sections, true);
    }
});
