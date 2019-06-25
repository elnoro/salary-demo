<?php
declare(strict_types=1);

namespace App\Accounting\PayAdjustment;

use App\Accounting\Employee;
use Money\Money;

final class CompanyCarUsageFee implements PayAdjustmentInterface
{
    public function adjust(Employee $employee): Money
    {
        if ($employee->usesCompanyCar()) {
            return Money::USD(500)->negative();
        }

        return Money::USD(0);
    }
}