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

        switch ($extension) {
            case 'csv':
                return new CsvFileReader();
            // Add more cases for other file formats if needed.
            default:
                throw new FileInvalidFormatException($extension);
        }
    }
}