<?php

namespace CommissionCalculator\Service\FileReader;

class CsvFileReader implements FileReaderInterface
{
    public function read(string $filePath): \Generator
    {
        if (($file = fopen($filePath, 'r')) !== false) {
            while (($line = fgetcsv($file)) !== false) {
                yield $line;
            }
            fclose($file);
        }
    }
}