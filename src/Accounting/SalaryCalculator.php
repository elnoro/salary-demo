<?php
declare(strict_types=1);

namespace App\Accounting;

use App\Accounting\PayAdjustment\PayAdjustmentInterface;
use App\Accounting\TaxCalculation\TaxCalculator;
use Money\Money;

final class SalaryCalculator implements PayCalculatorInterface
{
    /** @var TaxCalculator */
    private $taxCalculator;

    /** @var PayAdjustmentInterface[] */
    private $preTaxAdjustments;

    /** @var PayAdjustmentInterface[] */
    private $postTaxAdjustments;

    public function __construct(TaxCalculator $taxCalculator, array $preTaxAdjustments, array $postTaxAdjustments)
    {
        $this->taxCalculator = $taxCalculator;
        $this->preTaxAdjustments = $preTaxAdjustments;
        $this->postTaxAdjustments = $postTaxAdjustments;
    }

    public function calculate(Employee $employee): Payment
    {
        $grossPay = $this->calculateGrossPay($employee);
        $tax = $this->taxCalculator->calculateTax($employee, $grossPay);
        $netPay = $this->calculateNetPay($employee, $grossPay, $tax);

        return new Payment($employee, $netPay, $tax);
    }

    private function calculateGrossPay(Employee $employee): Money
    {
        $grossPay = $employee->getBaseSalary();
        foreach ($this->preTaxAdjustments as $preTaxAdjustment) {
            $grossPay = $grossPay->add($preTaxAdjustment->adjust($employee));
        }

        return $grossPay;
    }

    private function calculateNetPay(Employee $employee, Money $grossPay, Money $tax): Money
    {
        $netPay = $grossPay->subtract($tax);
        foreach ($this->postTaxAdjustments as $postTaxAdjustment) {
            $netPay = $netPay->add($postTaxAdjustment->adjust($employee));
        }

        return $netPay;
    }
}