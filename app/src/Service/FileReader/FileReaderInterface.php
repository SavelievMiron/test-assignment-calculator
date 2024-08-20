<?php

declare(strict_types=1);

namespace CommissionCalculator\Service\FileReader;

interface FileReaderInterface
{
    public function read(string $filePath): \Generator;
}