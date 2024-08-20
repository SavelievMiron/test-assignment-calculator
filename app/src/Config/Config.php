<?php

declare(strict_types=1);

namespace CommissionCalculator\Config;

class Config
{
    private string $depositFeeRate;
    private string $businessWithdrawFeeRate;
    private string $privateWithdrawFeeRate;
    private string $freeLimit;
    private int $freeOperationsLimit;
    private array $currencyDecimalPlaces;

    public function __construct(
        string $depositFeeRate,
        string $businessWithdrawFeeRate,
        string $privateWithdrawFeeRate,
        string $freeLimit,
        int    $freeOperationsLimit,
        array  $currencyDecimalPlaces
    )
    {
        $this->depositFeeRate = $depositFeeRate;
        $this->businessWithdrawFeeRate = $businessWithdrawFeeRate;
        $this->privateWithdrawFeeRate = $privateWithdrawFeeRate;
        $this->freeLimit = $freeLimit;
        $this->freeOperationsLimit = $freeOperationsLimit;
        $this->currencyDecimalPlaces = $currencyDecimalPlaces;
    }

    public function getDepositFeeRate(): string
    {
        return $this->depositFeeRate;
    }

    public function getBusinessWithdrawFeeRate(): string
    {
        return $this->businessWithdrawFeeRate;
    }

    public function getPrivateWithdrawFeeRate(): string
    {
        return $this->privateWithdrawFeeRate;
    }

    public function getFreeLimit(): string
    {
        return $this->freeLimit;
    }

    public function getFreeOperationsLimit(): int
    {
        return $this->freeOperationsLimit;
    }

    public function getCurrencyDecimalPlaces(string $currency): int
    {
        return $this->currencyDecimalPlaces[$currency] ?? 2;
    }
}