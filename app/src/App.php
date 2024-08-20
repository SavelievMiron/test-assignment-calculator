<?php

declare(strict_types=1);

namespace CommissionCalculator;

use CommissionCalculator\Exception\FileNotFoundException;
use CommissionCalculator\Exception\StrategyNotFoundException;
use CommissionCalculator\Model\Operation;
use CommissionCalculator\Service\CommissionCalculator;
use DateTime;

class App
{
    private CommissionCalculator $calculator;

    public function __construct(CommissionCalculator $commissionCalculator)
    {
        $this->calculator = $commissionCalculator;
    }

    /**
     * @throws StrategyNotFoundException
     */
    public function processOperations($filename): void
    {
        $file = fopen($filename, 'r');

        while (($line = fgetcsv($file)) !== false) {
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

        fclose($file);
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
