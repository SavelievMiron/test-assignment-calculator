<?php

namespace CommissionCalculator\RateSource;

interface RateSourceInterface
{
    public function getRates(): array;
}