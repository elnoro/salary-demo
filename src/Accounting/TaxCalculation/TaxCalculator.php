<?php

declare(strict_types=1);

namespace App\Accounting\TaxCalculation;

use App\Accounting\Employee;
use App\Accounting\TaxRate;
use Money\Money;

final class TaxCalculator
{
    /** @var BaseRateProviderInterface */
    private $baseRateProvider;
    /** @var DeductionInterface[] */
    private $deductions;

    public function __construct(BaseRateProviderInterface $baseRateProvider, array $deductions)
    {
        $this->baseRateProvider = $baseRateProvider;
        $this->deductions = $deductions;
    }

    public function calculateTax(Employee $employee, Money $grossPay): Money
    {
        $taxRate = $this->calculateTaxRate($employee);

        return $grossPay->multiply($taxRate->getTaxRate() / 100);
    }

    private function calculateTaxRate(Employee $employee): TaxRate
    {
        $taxRate = $this->baseRateProvider->getTaxRateFor($employee);

        foreach ($this->deductions as $deduction) {
            $taxRate = $deduction->deduct($employee, $taxRate);
        }

        return $taxRate;
    }
}
