<?php
declare(strict_types=1);

namespace App\Accounting\PayAdjustment\Tax;

use App\Accounting\Employee;
use App\Accounting\TaxRate;

interface DeductionInterface
{
    public function deduct(Employee $employee, TaxRate $taxRate);
}