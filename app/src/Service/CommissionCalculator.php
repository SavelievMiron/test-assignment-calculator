<?php

declare(strict_types=1);

namespace CommissionCalculator\Service;

use CommissionCalculator\Exception\StrategyNotFoundException;
use CommissionCalculator\Model\Operation;

class CommissionCalculator
{
    public function __construct(private readonly array $strategies)
    {}

    /**
     * Calculate Commission
     *
     * @param Operation $operation
     * @return string|null
     * @throws StrategyNotFoundException
     */
    public function calculateCommission(Operation $operation): ?string
    {
        $operationType = $operation->getType();
        $userType = $operation->getUserType();

        $strategyKey = $operationType . '_' . $userType;

        if (!isset($this->strategies[$strategyKey])) {
            throw new StrategyNotFoundException($operationType, $userType);
        }

        return $this->strategies[$strategyKey]->calculate($operation);
    }
}