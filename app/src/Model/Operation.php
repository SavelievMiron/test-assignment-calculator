<?php

declare(strict_types=1);

namespace CommissionCalculator\Model;

class Operation
{
    public function __construct(
        private readonly int       $userId,
        private readonly string    $userType,
        private readonly string    $type,
        private readonly string    $amount,
        private readonly string    $currency,
        private readonly \DateTime $date
    )
    {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }
}