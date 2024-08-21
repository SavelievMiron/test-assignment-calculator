<?php

declare(strict_types=1);

namespace CommissionCalculator;

use CommissionCalculator\Exception\FileInvalidFormatException;
use CommissionCalculator\Exception\FileNotFoundException;
use CommissionCalculator\Exception\StrategyNotFoundException;
use CommissionCalculator\Model\Operation;
use CommissionCalculator\Service\CommissionCalculator;
use CommissionCalculator\Service\FileReader\Factory\FileReaderFactory;
use DateTime;

class App
{
    private CommissionCalculator $calculator;

    public function __construct(CommissionCalculator $commissionCalculator)
    {
        $this->calculator = $commissionCalculator;
    }

    public function processOperations($filename): void
    {
        try {
            $fileReader = FileReaderFactory::create($filename);
        } catch (FileInvalidFormatException $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            exit();
        }

        foreach ($fileReader->read($filename) as $line) {
            $operation = $this->parseOperation($line);

            try {
                $fee = $this->calculator->calculateCommission($operation);
            } catch (StrategyNotFoundException $e) {
                echo 'Error: ' . $e->getMessage() . PHP_EOL;
                continue;
            } catch (FileNotFoundException $e) {
                echo 'Error: ' . $e->getMessage() . PHP_EOL;
                break;
            }

            echo $fee . PHP_EOL;
        }
    }

    private function parseOperation(array $data): Operation
    {
        return new Operation(
            (int) $data[1],
            $data[2],
            $data[3],
            $data[4],
            $data[5],
            DateTime::createFromFormat('Y-m-d', $data[0])
        );
    }
}
