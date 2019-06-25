<?php
declare(strict_types=1);

namespace App\Accounting\TaxCalculation\BaseRateProvider;

use App\Accounting\Employee;
use App\Accounting\TaxCalculation\BaseRateProviderInterface;
use App\Accounting\TaxRate;

final class HardcodedRateProvider implements BaseRateProviderInterface
{
    public function getTaxRateFor(Employee $employee): TaxRate
    {
        return new TaxRate(20);
    }
}