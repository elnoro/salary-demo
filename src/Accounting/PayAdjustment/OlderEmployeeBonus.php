<?php
declare(strict_types=1);

namespace App\Accounting\PayAdjustment;

use App\Accounting\Employee;
use Money\Money;

final class OlderEmployeeBonus implements PayAdjustmentInterface
{
    private const AGE_LIMIT = 50;
    private const BONUS = 0.07;

    public function adjust(Employee $employee): Money
    {
        if ($employee->getAge() > self::AGE_LIMIT) {
            return $employee->getBaseSalary()->multiply(self::BONUS);
        }

        return Money::USD(0);
    }
}