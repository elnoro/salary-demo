<?php

declare(strict_types=1);

namespace App\Accounting;

use Money\Money;

final class Employee
{
    /** @var string */
    private $name;

    /** @var Money */
    private $baseSalary;

    /** @var int */
    private $kids;

    /** @var bool */
    private $usesCompanyCar;

    /** @var int */
    private $age;

    public function __construct(string $name, Money $baseSalary, int $kids, bool $usesCompanyCar, int $age)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
        $this->kids = $kids;
        $this->usesCompanyCar = $usesCompanyCar;
        $this->age = $age;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBaseSalary(): Money
    {
        return $this->baseSalary;
    }

    public function getKids(): int
    {
        return $this->kids;
    }

    public function usesCompanyCar(): bool
    {
        return $this->usesCompanyCar;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
