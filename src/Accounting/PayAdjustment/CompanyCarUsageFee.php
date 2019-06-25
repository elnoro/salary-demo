<?php
declare(strict_types=1);

namespace App\Accounting\PayAdjustment;

use App\Accounting\Employee;
use Money\Money;

final class CompanyCarUsageFee implements PayAdjustmentInterface
{
    private const FEE = 500;

    public function adjust(Employee $employee): Money
    {
        if ($employee->usesCompanyCar()) {
            return Money::USD(self::FEE*100)->negative();
        }

        return Money::USD(0);
    }
}