<?php

use App\Accounting\PayAdjustment\CompanyCarUsageFee;
use App\Tests\DataBuilder\EmployeeBuilder;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class CompanyCarUsageFeeTest extends TestCase
{
    private const FEE_IN_DOLLARS = 99;
    /** @var CompanyCarUsageFee */
    private $companyCarUsageFee;

    /** @var Money */
    private $expectedFee;

    protected function setUp()
    {
        $this->expectedFee = Money::USD(99 * 100);
        $this->companyCarUsageFee = new CompanyCarUsageFee($this->expectedFee);
    }

    /**
     * @test
     */
    public function appliesCompanyCarUsageFee(): void
    {
        $employee = EmployeeBuilder::anEmployee()
            ->usesCompanyCar()
            ->build();

        $adjustment = $this->companyCarUsageFee->adjust($employee);

        $this->assertTrue($adjustment->equals($this->expectedFee->negative()));
    }

    /**
     * @test
     */
    public function feeIsNotAppliedIfEmployeeDoesNotUseCompanyCar(): void
    {
        $employee = EmployeeBuilder::anEmployee()
            ->build();

        $adjustment = $this->companyCarUsageFee->adjust($employee);

        $this->assertEquals(0, $adjustment->getAmount());
    }

    /**
     * @test
     */
    public function feeCanBePassedAsDollarAmount(): void
    {
        $companyCarUsageFee = CompanyCarUsageFee::fromDollars(self::FEE_IN_DOLLARS);

        $adjustment = $companyCarUsageFee->adjust(EmployeeBuilder::anEmployee()->usesCompanyCar()->build());

        $this->assertTrue($adjustment->equals($this->expectedFee->negative()));
    }
}
