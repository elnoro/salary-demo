<?php
declare(strict_types=1);

namespace App\Accounting\PayAdjustment\Tax;

use App\Accounting\Employee;
use App\Accounting\TaxRate;

interface BaseRateProviderInterface
{
    public function getTaxRateFor(Employee $employee): TaxRate;
}