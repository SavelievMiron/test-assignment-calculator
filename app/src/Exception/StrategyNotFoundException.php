<?php

declare(strict_types=1);

namespace CommissionCalculator\Exception;

use Exception;

class StrategyNotFoundException extends Exception
{
    public function __construct(string $operationType, string $userType)
    {
        $message = "No strategy found for operation type: $operationType and user type: $userType";
        parent::__construct($message);
    }
}