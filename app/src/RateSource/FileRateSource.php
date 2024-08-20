<?php

declare(strict_types=1);

namespace CommissionCalculator\RateSource;

use CommissionCalculator\Exception\FileNotFoundException;

class FileRateSource implements RateSourceInterface
{
    /**
     * @throws FileNotFoundException
     */
    public function getRates(): array
    {
        $filePath = ROOT_PATH . '/storage/files/rates.json';
        if (!file_exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        return json_decode(file_get_contents($filePath), true);
    }
}