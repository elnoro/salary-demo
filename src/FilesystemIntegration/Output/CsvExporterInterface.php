<?php

declare(strict_types=1);

namespace App\FilesystemIntegration\Output;

use App\Accounting\PayCalculatorInterface;
use Money\MoneyFormatter;

final class CsvExporterInterface implements SalaryExporterInterface
{
    /** @var PayCalculatorInterface */
    private $calculator;
    /** @var MoneyFormatter */
    private $moneyFormatter;

    public function __construct(PayCalculatorInterface $calculator, MoneyFormatter $moneyFormatter)
    {
        $this->calculator = $calculator;
        $this->moneyFormatter = $moneyFormatter;
    }

    public function export(string $to, iterable $employees): void
    {
        $file = fopen($to, 'w+');
        fputcsv($file, ['Employee', 'Net Pay', 'Tax']);

        foreach ($employees as $employee) {
            $payment = $this->calculator->calculate($employee);
            fputcsv($file, [
                $payment->getTo(),
                $this->moneyFormatter->format($payment->getNetPay()),
                $this->moneyFormatter->format($payment->getTax()),
            ]);
        }

        fclose($file);
    }
}
