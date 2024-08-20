<?php

namespace CommissionCalculator\Strategy\Commission;

use CommissionCalculator\Model\Operation;

interface CommissionStrategyInterface
{
    public function calculate(Operation $operation): string;
}