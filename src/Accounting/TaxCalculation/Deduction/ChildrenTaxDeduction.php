<?php
declare(strict_types=1);

namespace App\Accounting\TaxCalculation;

use App\Accounting\Employee;
use App\Accounting\TaxRate;

final class ChildrenTaxDeduction
{
    public function deduct(Employee $employee, TaxRate $taxRate): TaxRate
    {
        if ($employee->getKids() > 2) {
            return $taxRate->deduct(5);
        }

        return $taxRate;
    }
}