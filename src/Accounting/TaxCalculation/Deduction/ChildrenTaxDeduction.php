<?php

declare(strict_types=1);

namespace App\Accounting\TaxCalculation\Deduction;

use App\Accounting\Employee;
use App\Accounting\TaxCalculation\DeductionInterface;
use App\Accounting\TaxRate;

final class ChildrenTaxDeduction implements DeductionInterface
{
    private const KIDS_FOR_TAX_DEDUCTION = 2;
    private const TAX_DEDUCTION = 2;

    public function apply(Employee $employee, TaxRate $taxRate): TaxRate
    {
        if ($employee->getKids() > self::KIDS_FOR_TAX_DEDUCTION) {
            return $taxRate->deduct(self::TAX_DEDUCTION);
        }

        return $taxRate;
    }
}
