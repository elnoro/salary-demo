<?php
declare(strict_types=1);

namespace App\Accounting;

interface PaymentCalculatorInterface
{
    public function calculate(Employee $employee): Payment;
}