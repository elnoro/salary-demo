<?php

declare(strict_types=1);

namespace App\FilesystemIntegration\Input;

use App\Accounting\Employee;
use Money\MoneyParser;

final class CsvReader implements EmployeeReaderInterface
{
    /** @var MoneyParser */
    private $moneyParser;

    public function __construct(MoneyParser $moneyParser)
    {
        $this->moneyParser = $moneyParser;
    }

    /**
     * @param string $filename
     *
     * @return iterable|Employee[]
     */
    public function read(string $filename): iterable
    {
        $employeesFile = fopen($filename, 'r+');
        $header = true;
        while ($line = fgetcsv($employeesFile, 0, ';')) {
            if ($header) {
                $header = false;
                continue;
            }

            yield $this->parseEmployee($line);
        }

        fclose($employeesFile);
    }

    private function parseEmployee(array $line): Employee
    {
        [$name, $age, $kids, $salary, $usesCompanyCar] = $line;
        $usesCompanyCar = 'Yes' === $usesCompanyCar;
        $salary = $this->moneyParser->parse($salary, 'USD');

        return new Employee($name, $salary, (int) $kids, $usesCompanyCar, (int) $age);
    }
}
