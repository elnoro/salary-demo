<?php

declare(strict_types=1);

namespace App\Accounting\PayAdjustment;

use App\Accounting\Employee;
use Money\Money;

final class CompanyCarUsageFee implements PayAdjustmentInterface
{
    /** @var Money */
    private $fee;

    public static function fromDollars(int $fee): self
    {
        return new self(Money::USD($fee * 100));
    }

    public function __construct(Money $fee)
    {
        $this->fee = $fee;
        if ($this->fee->isNegative()) {
            throw new \InvalidArgumentException('Fee must be positive');
        }
    }

    public function adjust(Employee $employee): Money
    {
        if ($employee->usesCompanyCar()) {
            return $this->fee->negative();
        }

        return Money::USD(0);
    }
}
