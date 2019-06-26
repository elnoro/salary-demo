<?php

declare(strict_types=1);

namespace App\Accounting\PayAdjustment;

use App\Accounting\Employee;
use Money\Money;

final class OlderEmployeeBonus implements PayAdjustmentInterface
{
    /** @var int */
    private $ageLimit;
    /** @var float */
    private $bonus;

    public function __construct(int $ageLimit, float $bonus)
    {
        $this->ageLimit = $ageLimit;
        $this->bonus = $bonus;
    }

    public function adjust(Employee $employee): Money
    {
        if ($employee->getAge() > $this->ageLimit) {
            return $employee->getBaseSalary()->multiply($this->bonus);
        }

        return Money::USD(0);
    }
}
