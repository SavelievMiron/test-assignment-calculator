<?php

namespace CommissionCalculator\Tests;

use CommissionCalculator\App;
use CommissionCalculator\Service\CommissionCalculator;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    private App $app;
    private CommissionCalculator $commissionCalculatorMock;

    protected function setUp(): void
    {
        $this->commissionCalculatorMock = $this->createMock(CommissionCalculator::class);

        $this->app = new App($this->commissionCalculatorMock);
    }

    public function testProcessOperationsWithTestFiles(): void
    {
        $inputFile = __DIR__ . '/fixtures/input.csv';
        $outputFile = __DIR__ . '/fixtures/output.csv';

        $expectedOutput = file($outputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $this->commissionCalculatorMock->expects($this->exactly(count($expectedOutput)))
            ->method('calculateCommission')
            ->willReturnOnConsecutiveCalls(...$expectedOutput);

        ob_start();
        $this->app->processOperations($inputFile);
        $actualOutput = ob_get_clean();

        $this->assertEquals(implode("\n", $expectedOutput) . "\n", $actualOutput);
    }
}