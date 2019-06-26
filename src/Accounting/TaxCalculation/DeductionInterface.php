<?php

declare(strict_types=1);

namespace App\Accounting\TaxCalculation;

use App\Accounting\Employee;
use App\Accounting\TaxRate;

interface DeductionInterface
{
    public function apply(Employee $employee, TaxRate $taxRate);
}
