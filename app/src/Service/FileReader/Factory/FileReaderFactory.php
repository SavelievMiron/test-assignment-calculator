<?php

declare(strict_types=1);

namespace CommissionCalculator\Service\FileReader\Factory;

use CommissionCalculator\Exception\FileInvalidFormatException;
use CommissionCalculator\Service\FileReader\FileReaderInterface;
use CommissionCalculator\Service\FileReader\CsvFileReader;

class FileReaderFactory
{
    public static function create(string $filePath): FileReaderInterface
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        return match ($extension) {
            'csv' => new CsvFileReader(),
            default => throw new FileInvalidFormatException($extension),
        };
    }
}