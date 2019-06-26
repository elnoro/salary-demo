<?php

declare(strict_types=1);

namespace App\Tests\DataBuilder;

use App\Accounting\Employee;
use Money\Money;

final class EmployeeBuilder
{
    /** @var string */
    private $name = 'test employee';

    /** @var int */
    private $baseSalary = 1000;

    /** @var int */
    private $kids = 0;

    /** @var bool */
    private $usesCompanyCar = false;

    /** @var int */
    private $age = 10;

    public static function anEmployee(): self
    {
        return new self();
    }

    private function construct()
    {
    }

    public function withAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function usesCompanyCar(): self
    {
        $this->usesCompanyCar = true;

        return $this;
    }

    public function withSalary(int $salary): self
    {
        $this->baseSalary = $salary;

        return $this;
    }

    public function withKids(int $kids): self
    {
        $this->kids = $kids;

        return $this;
    }

    public function build(): Employee
    {
        return new Employee(
            $this->name,
            Money::USD($this->baseSalary * 100),
            $this->kids,
            $this->usesCompanyCar,
            $this->age
        );
    }
}
