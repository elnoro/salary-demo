<?php

declare(strict_types=1);

namespace App\Accounting;

final class TaxRate
{
    /** @var int */
    private $taxRate;

    public function __construct(int $taxRate)
    {
        if ($taxRate > 100 || $taxRate < 0) {
            throw new \InvalidArgumentException('Tax Rate must be between 0 and 100');
        }
        $this->taxRate = $taxRate;
    }

    public function getTaxRate(): int
    {
        return $this->taxRate;
    }

    public function deduct(int $percent): self
    {
        if ($percent < 0) {
            throw new \InvalidArgumentException('Tax Rate must be between 0 and 100');
        }

        return new self($this->taxRate - $percent);
    }
}
