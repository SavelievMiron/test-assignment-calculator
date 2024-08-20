<?php

declare(strict_types=1);

namespace CommissionCalculator\Strategy\Commission;

use CommissionCalculator\Config\Config;
use CommissionCalculator\Model\Operation;

class DepositCommissionStrategy implements CommissionStrategyInterface
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Calculate commission
     *
     * @param Operation $operation
     * @return string
     */
    public function calculate(Operation $operation): string
    {
        $fee = bcmul($operation->getAmount(), $this->config->getDepositFeeRate(), 6);
        return $this->roundUp($fee, $operation->getCurrency());
    }

    /**
     * Round up the number
     *
     * @param string $amount
     * @param string $currency
     * @return string
     */
    private function roundUp(string $amount, string $currency): string
    {
        $decimalPlaces = $this->config->getCurrencyDecimalPlaces($currency);
        $factor = bcpow('10', (string) $decimalPlaces, 0);
        return bcdiv(
            (string) ceil(
                (float) bcmul($amount, $factor, 0)
            ),
            $factor,
            $decimalPlaces
        );
    }
}