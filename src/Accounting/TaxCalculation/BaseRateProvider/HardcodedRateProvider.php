<?php
declare(strict_types=1);

namespace App\Accounting\TaxCalculation;

use App\Accounting\Employee;
use App\Accounting\PayAdjustment\Tax\BaseRateProviderInterface;
use App\Accounting\TaxRate;

final class HardcodedRateProvider implements BaseRateProviderInterface
{
    public function getTaxRateFor(Employee $employee): TaxRate
    {
        return new TaxRate(20);
    }
}