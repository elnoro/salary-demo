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

    public function __construct($name, Money $baseSalary, int $kids, bool $usesCompanyCar, int $age)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
        $this->kids = $kids;
        $this->usesCompanyCar = $usesCompanyCar;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Money
     */
    public function getBaseSalary(): Money
    {
        return $this->baseSalary;
    }

    /**
     * @return int
     */
    public function getKids(): int
    {
        return $this->kids;
    }

    /**
     * @return bool
     */
    public function usesCompanyCar(): bool
    {
        return $this->usesCompanyCar;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }
}