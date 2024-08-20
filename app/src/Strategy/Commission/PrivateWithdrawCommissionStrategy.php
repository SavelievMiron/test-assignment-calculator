<?php

declare(strict_types=1);

namespace CommissionCalculator\Strategy\Commission;

use CommissionCalculator\Config\Config;
use CommissionCalculator\Model\Operation;
use CommissionCalculator\Utils\CurrencyConvertor;

class PrivateWithdrawCommissionStrategy implements CommissionStrategyInterface
{
    private Config $config;
    private CurrencyConvertor $converter;
    private array $userOperations;

    public function __construct(Config $config, CurrencyConvertor $converter, array &$userOperations)
    {
        $this->config = $config;
        $this->converter = $converter;
        $this->userOperations = &$userOperations;
    }

    /**
     * Calculate commission
     *
     * @param Operation $operation
     * @return string
     */
    public function calculate(Operation $operation): string
    {
        $userId = $operation->getUserId();
        $amount = $operation->getAmount();
        $currency = $operation->getCurrency();

        $userKey = "{$operation->getDate()->format('Y')}-{$operation->getDate()->format('W')}";

        $amountInEuro = $this->converter->convertToEuro($amount, $currency);

        // Initialize the user's operations for the week if not already done
        if (!isset($this->userOperations[$userId][$userKey])) {
            $this->userOperations[$userId][$userKey] = [
                'operations' => 0,
                'total_in_euro' => '0.00'
            ];
        }

        $userWeekOperations = &$this->userOperations[$userId][$userKey];

        // If the first 3 operations are within the free limit
        if ($userWeekOperations['operations'] <= $this->config->getFreeOperationsLimit()) {
            // Calculate the total amount including this operation
            $newTotalInEuro = bcadd($userWeekOperations['total_in_euro'], $amountInEuro, 6);

            if ($newTotalInEuro <= $this->config->getFreeLimit()) {
                // The new total is within the free limit, no fee is applied
                $userWeekOperations['total_in_euro'] = $newTotalInEuro;
                $userWeekOperations['operations']++;
                return '0';
            } else {
                // Part of the amount exceeds the free limit
                $excessInEuro = bcsub($newTotalInEuro, $this->config->getFreeLimit(), 6);
                $feeInEuro = bcmul($excessInEuro, $this->config->getPrivateWithdrawFeeRate(), 6);
                $fee = $this->converter->convertFromEuro($feeInEuro, $currency);

                // Update the user's operations
                $userWeekOperations['total_in_euro'] = $this->config->getFreeLimit();
                $userWeekOperations['operations']++;
                return $this->roundUp($fee, $currency);
            }
        } else {
            // For the 4th and subsequent operations, the entire amount is charged
            $feeInEuro = bcmul($amountInEuro, $this->config->getPrivateWithdrawFeeRate(), 6);
            $fee = $this->converter->convertFromEuro($feeInEuro, $currency);

            // Update the user's operations
            $userWeekOperations['total_in_euro'] = bcadd($userWeekOperations['total_in_euro'], $amountInEuro, 6);
            $userWeekOperations['operations']++;
            return $this->roundUp($fee, $currency);
        }
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