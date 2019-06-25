<?php

declare(strict_types=1);

namespace App\Accounting;

interface PayCalculatorInterface
{
    public function calculate(Employee $employee): Payment;
}
