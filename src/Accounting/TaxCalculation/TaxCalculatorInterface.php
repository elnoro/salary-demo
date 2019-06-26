<?php

declare(strict_types=1);

namespace App\Accounting\TaxCalculation;

use App\Accounting\Employee;
use Money\Money;

interface TaxCalculatorInterface
{
    public function calculateTax(Employee $employee, Money $grossPay): Money;
}
