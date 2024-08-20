<?php

declare(strict_types=1);

namespace CommissionCalculator\Exception;

use Exception;

class FileInvalidFormatException extends Exception
{
    public function __construct(string $extension)
    {
        $message = 'The format ' . $extension . ' is not supported by FileReader.';
        parent::__construct($message);
    }
}