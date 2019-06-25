<?php

namespace App\FilesystemIntegration\Output;

use App\Accounting\Employee;

interface SalaryExporterInterface
{
    /**
     * @param string $to
     * @param Employee[] $employees
     */
    public function export(string $to, iterable $employees): void;
}