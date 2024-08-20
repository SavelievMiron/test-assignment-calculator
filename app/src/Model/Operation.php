<?php

declare(strict_types=1);

namespace CommissionCalculator\Model;

class Operation
{
    private int $userId;
    private string $userType;
    private string $type;
    private string $amount;
    private string $currency;
    private \DateTime $date;

    public function __construct(
        int       $userId,
        string    $userType,
        string    $type,
        string     $amount,
        string    $currency,
        \DateTime $date
    )
    {
        $this->userId = $userId;
        $this->userType = $userType;
        $this->type = $type;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->date = $date;
    }

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