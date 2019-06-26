<?php

use App\Tests\DataBuilder\EmployeeBuilder;
use App\Accounting\TaxCalculation\Deduction\ChildrenTaxDeduction;
use App\Accounting\TaxRate;
use PHPUnit\Framework\TestCase;

final class ChildrenTaxDeductionTest extends TestCase
{
    private const BASE_RATE = 20;
    private const LOWER_RATE = 18;

    private const MANY_KIDS = 3;
    private const FEW_KIDS = 2;

    /** @var ChildrenTaxDeduction */
    private $childrenTaxDeduction;

    protected function setUp()
    {
        $this->childrenTaxDeduction = new ChildrenTaxDeduction();
    }

    /**
     * @test
     */
    public function lowersTaxRateForEmployeesWithManyKids(): void
    {
        $employee = EmployeeBuilder::anEmployee()
            ->withKids(self::MANY_KIDS)
            ->build();

        $afterDeduction = $this->childrenTaxDeduction->apply($employee, new TaxRate(self::BASE_RATE));

        $this->assertEquals(self::LOWER_RATE, $afterDeduction->getTaxRate());
    }

    /**
     * @test
     */
    public function ignoresEmployeesWithFewKids(): void
    {
        $employee = EmployeeBuilder::anEmployee()
            ->withKids(self::FEW_KIDS)
            ->build();

        $afterDeduction = $this->childrenTaxDeduction->apply($employee, new TaxRate(self::BASE_RATE));

        $this->assertEquals(self::BASE_RATE, $afterDeduction->getTaxRate());
    }
}
