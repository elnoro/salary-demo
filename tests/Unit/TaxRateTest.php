<?php

use App\Accounting\TaxRate;
use PHPUnit\Framework\TestCase;

final class TaxRateTest extends TestCase
{
    public static function invalidTaxRates(): array
    {
        return [
            [-1],
            [101],
        ];
    }

    /**
     * @dataProvider invalidTaxRates
     * @test
     */
    public function cannotCreateTaxRateThatIsNotPercent($taxRate): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new TaxRate($taxRate);
    }

    /**
     * @test
     */
    public function canDeductPercentsFromTaxRate(): void
    {
        $taxRate = new TaxRate(20);

        $afterDeduction = $taxRate->deduct(10);

        $this->assertEquals(10, $afterDeduction->getTaxRate());
    }

    /**
     * @dataProvider invalidTaxRates
     * @test
     */
    public function deductionsAreValidated($invalidTaxRate): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new TaxRate(20))->deduct($invalidTaxRate);
    }
}
