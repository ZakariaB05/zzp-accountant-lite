<?php

namespace App\Helpers;

/**
 * Eenvoudige belastingberekeningen voor ZZP'ers.
 * Alle methodes zijn static, zodat je ze overal kunt gebruiken zonder object.
 */
class TaxCalculator
{
    /** Fiscale kilometervergoeding per zakelijke kilometer (in euro's). */
    public const KM_RATE = 0.23;

    /** Fiscale aftrekpost voor het aantal zakelijke kilometers. */
    public static function kmDeduction(float $kilometers): float
    {
        return round($kilometers * self::KM_RATE, 2);
    }

    /** Bedrag exclusief BTW van een shift. */
    public static function amountExclVat(float $hours, float $hourlyRate): float
    {
        return round($hours * $hourlyRate, 2);
    }

    /** BTW-bedrag over een bedrag exclusief BTW (bijv. 21 of 9). */
    public static function vatAmount(float $amountExcl, int $vatRate): float
    {
        return round($amountExcl * $vatRate / 100, 2);
    }

    /** Nettowinst = Brutowinst - (Onkosten + Kilometervergoeding). */
    public static function netProfit(float $grossProfit, float $expenses, float $kmDeduction): float
    {
        return round($grossProfit - ($expenses + $kmDeduction), 2);
    }

    /** BTW-reservering = Ontvangen BTW - Betaalde BTW. */
    public static function vatReserve(float $vatReceived, float $vatPaid): float
    {
        return round($vatReceived - $vatPaid, 2);
    }
}
