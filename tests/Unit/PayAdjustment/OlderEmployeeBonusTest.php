<?php

use App\Accounting\PayAdjustment\OlderEmployeeBonus;
use App\Tests\DataBuilder\EmployeeBuilder;
use PHPUnit\Framework\TestCase;

final class OlderEmployeeBonusTest extends TestCase
{
    private const AGE_LIMIT = 100;
    private const BONUS = 0.1;
    private const EXPECTED_INCREASE = 100;

    /** @var OlderEmployeeBonus */
    private $olderEmployeeBonus;

    /** @var EmployeeBuilder */
    private $employeeBuilder;

    protected function setUp()
    {
        $this->olderEmployeeBonus = new OlderEmployeeBonus(self::AGE_LIMIT, self::BONUS);
        $this->employeeBuilder = EmployeeBuilder::anEmployee();
    }

    public function ageBonusProvider(): array
    {
        return [
            [self::AGE_LIMIT + 1, self::EXPECTED_INCREASE, 'Older employees must get the bonus'],
            [self::AGE_LIMIT - 1, 0, 'Younger employess don\'t get the bonus'],
            [self::AGE_LIMIT, 0, 'Age check is strict'],
        ];
    }

    /**
     * @dataProvider ageBonusProvider
     * @test
     */
    public function givesBonusToOlderEmployees($age, $expectedIncrease, $errorMessage): void
    {
        $employee = $this->employeeBuilder->withAge($age)->build();

        $this->assertEquals(
            $expectedIncrease * 100,
            $this->olderEmployeeBonus->adjust($employee)->getAmount()
        );
    }
}
