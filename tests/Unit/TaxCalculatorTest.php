<?php

namespace Tests\Unit;

use App\Helpers\TaxCalculator;
use PHPUnit\Framework\TestCase;

class TaxCalculatorTest extends TestCase
{
    public function test_km_deduction_is_23_cents_per_kilometer(): void
    {
        $this->assertSame(23.00, TaxCalculator::kmDeduction(100));
        $this->assertSame(2.30, TaxCalculator::kmDeduction(10));
        $this->assertSame(57.50, TaxCalculator::kmDeduction(250));
    }

    public function test_zero_kilometers_gives_zero_deduction(): void
    {
        $this->assertSame(0.00, TaxCalculator::kmDeduction(0));
    }

    public function test_net_profit_subtracts_expenses_and_km_deduction(): void
    {
        // 5000 omzet - (800 onkosten + 23 km-aftrek) = 4177
        $this->assertSame(4177.00, TaxCalculator::netProfit(5000, 800, 23));
    }

    public function test_vat_reserve_is_received_minus_paid(): void
    {
        $this->assertSame(630.00, TaxCalculator::vatReserve(1050, 420));
    }

    public function test_shift_amounts(): void
    {
        $excl = TaxCalculator::amountExclVat(8, 50); // 400
        $this->assertSame(400.00, $excl);
        $this->assertSame(84.00, TaxCalculator::vatAmount($excl, 21));
        $this->assertSame(36.00, TaxCalculator::vatAmount($excl, 9));
    }
}
