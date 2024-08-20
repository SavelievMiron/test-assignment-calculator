<?php

define('ROOT_PATH', __DIR__);

require_once './vendor/autoload.php';

use CommissionCalculator\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required([
    'EXCHANGE_RATES_ACCESS_KEY',
    'DEPOSIT_FEE_RATE',
    'BUSINESS_WITHDRAW_FEE_RATE',
    'PRIVATE_WITHDRAW_FEE_RATE',
    'FREE_LIMIT',
    'FREE_OPERATIONS_LIMIT',
    'CURRENCY_DECIMAL_PLACES_EUR',
    'CURRENCY_DECIMAL_PLACES_USD',
    'CURRENCY_DECIMAL_PLACES_JPY'
])->notEmpty();

$containerFactory = require __DIR__ . '/config/di.php';
$container = $containerFactory();

$app = $container->get(App::class);

$app->processOperations(__DIR__ . '/storage/files/transactions.csv');