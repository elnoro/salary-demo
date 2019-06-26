<?php

use App\Accounting\Employee;
use App\Accounting\TaxCalculation\BaseRateProviderInterface;
use App\Accounting\TaxCalculation\DeductionInterface;
use App\Accounting\TaxCalculation\TaxCalculator;
use App\Accounting\TaxRate;
use App\Tests\DataBuilder\EmployeeBuilder;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TaxCalculatorTest extends TestCase
{
    private const EXPECTED_BASE_RATE = 100;
    private const EXPECTED_FIRST_DEDUCTION = 50;

    /** @var BaseRateProviderInterface|MockObject */
    private $baseRateProvider;
    /** @var DeductionInterface|MockObject */
    private $firstDeduction;
    /** @var DeductionInterface|MockObject */
    private $secondDeduction;

    /** @var Employee */
    private $employee;

    /** @var TaxCalculator */
    private $taxCalculator;

    protected function setUp()
    {
        $this->baseRateProvider = $this->createMock(BaseRateProviderInterface::class);
        $this->firstDeduction = $this->createMock(DeductionInterface::class);
        $this->secondDeduction = $this->createMock(DeductionInterface::class);

        $this->taxCalculator = new TaxCalculator($this->baseRateProvider, [$this->firstDeduction, $this->secondDeduction]);

        $this->employee = EmployeeBuilder::anEmployee()->build();
    }

    public static function taxCalculationResults(): array
    {
        return [
            [20, 100, 20],
            [100, 100, 100],
            [0, 100, 0],
        ];
    }

    /**
     * @dataProvider taxCalculationResults
     * @test
     */
    public function calculatesTaxWithDeductions($lastDeduction, $grossPay, $afterTax): void
    {
        $this->baseRateIs(self::EXPECTED_BASE_RATE);
        $this->firstDeductionTransformsTaxRate(self::EXPECTED_BASE_RATE, self::EXPECTED_FIRST_DEDUCTION);
        $this->secondDeductionTransformsTaxRate(self::EXPECTED_FIRST_DEDUCTION, $lastDeduction);

        $calculatedTax = $this->taxCalculator->calculateTax($this->employee, Money::USD($grossPay));
        $expectedTax = Money::USD($afterTax);
        $this->assertTrue($calculatedTax->equals($expectedTax));
    }

    private function firstDeductionTransformsTaxRate(int $from, int $to): void
    {
        $this->firstDeduction
            ->method('deduct')
            ->with($this->employee, new TaxRate($from))
            ->willReturn(new TaxRate($to));
    }

    private function secondDeductionTransformsTaxRate(int $from, int $to): void
    {
        $this->secondDeduction
            ->method('deduct')
            ->with($this->employee, new TaxRate($from))
            ->willReturn(new TaxRate($to));
    }

    private function baseRateIs(int $baseRate): void
    {
        $this->baseRateProvider->method('getTaxRateFor')
            ->with($this->employee)
            ->willReturn(new TaxRate($baseRate));
    }
}
