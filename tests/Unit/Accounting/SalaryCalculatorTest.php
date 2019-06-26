<?php

use App\Accounting\PayAdjustment\PayAdjustmentInterface;
use App\Accounting\SalaryCalculator;
use App\Accounting\TaxCalculation\TaxCalculatorInterface;
use App\Tests\DataBuilder\EmployeeBuilder;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SalaryCalculatorTest extends TestCase
{
    /** @var TaxCalculatorInterface|MockObject */
    private $taxCalculator;
    /** @var PayAdjustmentInterface|MockObject */
    private $preTaxAdjustment;
    /** @var PayAdjustmentInterface|MockObject */
    private $postTaxAdjustment;

    /** @var SalaryCalculator */
    private $salaryCalculator;

    protected function setUp()
    {
        $this->taxCalculator = $this->createMock(TaxCalculatorInterface::class);
        $this->preTaxAdjustment = $this->createMock(PayAdjustmentInterface::class);
        $this->postTaxAdjustment = $this->createMock(PayAdjustmentInterface::class);

        $this->salaryCalculator = new SalaryCalculator(
            $this->taxCalculator,
            [$this->preTaxAdjustment],
            [$this->postTaxAdjustment]
        );
    }

    /**
     * @test
     */
    public function taxesAreCalculatedOnGrossPay(): void
    {
        $employee = EmployeeBuilder::anEmployee()->withSalary(1000)->build();
        $this->preTaxBonusIs(1000, $employee);
        $this->postTaxAdjustmentIs(0, $employee);

        $expectedTax = Money::USD(100);
        $this->taxCalculator->expects($this->atLeastOnce())
            ->method('calculateTax')
            ->with($employee, Money::USD(2000 * 100))
            ->willReturn($expectedTax);

        $payment = $this->salaryCalculator->calculate($employee);

        $this->assertTrue($expectedTax->equals($payment->getTax()));
    }

    /**
     * @test
     */
    public function netPayIncludesTaxesAndAdjustments(): void
    {
        $employee = EmployeeBuilder::anEmployee()->withSalary(1000)->build();
        $this->preTaxBonusIs(0, $employee);
        $this->postTaxAdjustmentIs(-500, $employee);

        $expectedTax = Money::USD(500 * 100);
        $this->taxCalculator->method('calculateTax')->willReturn($expectedTax);

        $payment = $this->salaryCalculator->calculate($employee);

        $this->assertTrue($expectedTax->equals($payment->getTax()));
        $this->assertEquals(0, $payment->getNetPay()->getAmount());
    }

    public function preTaxBonusIs(int $dollars, $employee): void
    {
        $this->preTaxAdjustment
            ->method('adjust')
            ->with($employee)
            ->willReturn(Money::USD($dollars * 100));
    }

    public function postTaxAdjustmentIs(int $dollars, $employee): void
    {
        $this->postTaxAdjustment
            ->method('adjust')
            ->with($employee)
            ->willReturn(Money::USD($dollars * 100));
    }
}
