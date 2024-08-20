<?php

declare(strict_types=1);

namespace CommissionCalculator\Exception;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct(string $filePath)
    {
        $message = 'The file with rates not found by the path ' . $filePath;
        parent::__construct($message);
    }
}