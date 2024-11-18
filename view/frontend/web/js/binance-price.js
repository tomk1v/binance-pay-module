<!--
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv
 */
-->
define(['jquery'], function ($) {
    'use strict';

    return function (config) {
        function isValidCurrency(currency) {
            return currency.toUpperCase() === 'USD';
        }

        function connectAvgPriceWebSocket() {
            if (!isValidCurrency(config.storeCurrency)) {
                $('.crypto-amount').each(function () {
                    $(this).fadeOut(200, function () {
                        $(this).text(`Currency is not supported. Please set the store currency to USD.`).fadeIn(200);
                    });
                });
                console.error(`Invalid store currency: ${config.storeCurrency}. Only USD is supported.`);
                return;
            }

            const socket = new WebSocket(`wss://stream.binance.com:9443/ws/${config.symbol}@avgPrice`);
            socket.onopen = function () {
                console.log(`WebSocket connection established for ${config.symbol} average price stream`);
            };

            socket.onmessage = function (event) {
                const data = JSON.parse(event.data);
                const avgPriceInUsdt = parseFloat(data.w);

                $('.crypto-amount').each(function () {
                    const defaultPrice = parseFloat($(this).data('amount'));
                    const cryptoPrice = (defaultPrice / avgPriceInUsdt).toFixed(6);

                    $(this).fadeOut(200, function () {
                        $(this).text(`Crypto Price: ${cryptoPrice} USD`).fadeIn(200);
                    });
                });
            };

            socket.onclose = function () {
                console.log("WebSocket connection closed, attempting to reconnect...");
                setTimeout(connectAvgPriceWebSocket, 5000);
            };

            socket.onerror = function (error) {
                console.error("WebSocket error:", error);
                socket.close();
            };
        }

        connectAvgPriceWebSocket();
    };
});
