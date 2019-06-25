<?php

declare(strict_types=1);

namespace App\Accounting;

use Money\Money;

final class Payment
{
    /** @var Employee */
    private $employee;

    /** @var Money */
    private $netPay;

    /** @var Money */
    private $tax;

    public function __construct(Employee $employee, Money $netPay, Money $tax)
    {
        $this->employee = $employee;
        $this->netPay = $netPay;
        $this->tax = $tax;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->employee->getName();
    }

    /**
     * @return Money
     */
    public function getNetPay(): Money
    {
        return $this->netPay;
    }

    /**
     * @return Money
     */
    public function getTax(): Money
    {
        return $this->tax;
    }
}
