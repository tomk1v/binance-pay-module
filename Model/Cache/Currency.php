<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Cache;

class Currency
{
    private const CACHE_KEY = 'binance_supported_currencies';
    private const CACHE_LIFETIME = 86400;

    /**
     * @param \Magento\Framework\App\CacheInterface $cache
     * @param \Internship\BinancePay\Service\BinancePay $binancePay
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     */
    public function __construct(
        private readonly \Magento\Framework\App\CacheInterface $cache,
        private readonly \Internship\BinancePay\Service\BinancePay $binancePay,
        private readonly \Magento\Framework\Serialize\Serializer\Json $jsonSerializer,
    ) {
    }

    /**
     * Fetches currencies from cache or updates the cache if empty or outdated.
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrencies(): array
    {
        try {
            $cachedData = $this->cache->load(self::CACHE_KEY);

            if ($cachedData) {
                return $this->jsonSerializer->unserialize($cachedData);
            }

            return $this->fetchAndCacheCurrencies();
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__());
        }
    }

    /**
     * Fetches currencies from Binance API.
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function fetchAndCacheCurrencies(): array
    {
        try {
            $currencies = $this->binancePay->getSupportedCurrencies();

            $this->cache->save(
                $this->jsonSerializer->serialize($currencies),
                self::CACHE_KEY,
                [],
                self::CACHE_LIFETIME
            );

            return $currencies;
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }
    }
}
