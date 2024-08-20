<?php

use CommissionCalculator\Config\Config;
use CommissionCalculator\RateSource\ExchangeRatesApiRateSource;
use CommissionCalculator\RateSource\FileRateSource;
use CommissionCalculator\Service\CommissionCalculator;
use CommissionCalculator\Strategy\Commission\BusinessWithdrawCommissionStrategy;
use CommissionCalculator\Strategy\Commission\DepositCommissionStrategy;
use CommissionCalculator\Strategy\Commission\PrivateWithdrawCommissionStrategy;
use CommissionCalculator\Utils\CurrencyConvertor;
use DI\ContainerBuilder;

return function () {
    $containerBuilder = new ContainerBuilder();

    $containerBuilder->addDefinitions([
        Config::class => DI\create(Config::class)->constructor(
            $_ENV['DEPOSIT_FEE_RATE'],
            $_ENV['BUSINESS_WITHDRAW_FEE_RATE'],
            $_ENV['PRIVATE_WITHDRAW_FEE_RATE'],
            $_ENV['FREE_LIMIT'],
            (int) $_ENV['FREE_OPERATIONS_LIMIT'],
            [
                'EUR' => (int) $_ENV['CURRENCY_DECIMAL_PLACES_EUR'],
                'USD' => (int) $_ENV['CURRENCY_DECIMAL_PLACES_USD'],
                'JPY' => (int) $_ENV['CURRENCY_DECIMAL_PLACES_JPY'],
            ]
        ),
        'commission_strategies' => [
            'deposit_business' => DI\create(DepositCommissionStrategy::class)
                ->constructor(DI\get(Config::class)),
            'deposit_private' => DI\create(DepositCommissionStrategy::class)
                ->constructor(DI\get(Config::class)),
            'withdraw_business' => DI\create(BusinessWithdrawCommissionStrategy::class)
                ->constructor(DI\get(Config::class)),
            'withdraw_private' => DI\create(PrivateWithdrawCommissionStrategy::class)
                ->constructor(DI\get(Config::class), DI\get(CurrencyConvertor::class), []),
        ],
        CurrencyConvertor::class => DI\create(CurrencyConvertor::class)->constructor(DI\get(FileRateSource::class)),
        CommissionCalculator::class => DI\create(CommissionCalculator::class)
            ->constructor(DI\get('commission_strategies')),
    ]);

    return $containerBuilder->build();
};