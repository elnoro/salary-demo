<?php


namespace App\Accounting\PayAdjustment;

use App\Accounting\Employee;
use Money\Money;

interface PayAdjustmentInterface
{
    public function adjust(Employee $employee): Money;
}