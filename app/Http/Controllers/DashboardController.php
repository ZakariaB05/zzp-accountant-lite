<?php

namespace App\Http\Controllers;

use App\Helpers\TaxCalculator;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $year = now()->year;

        // --- Totalen dit jaar ---
        $revenue = (float) $user->shifts()
            ->whereYear('work_date', $year)
            ->selectRaw('COALESCE(SUM(hours * hourly_rate), 0) as total')
            ->value('total');

        $hours      = (float) $user->shifts()->whereYear('work_date', $year)->sum('hours');
        $kilometers = (float) $user->trips()->whereYear('trip_date', $year)->sum('kilometers');
        $expenses   = (float) $user->expenses()->whereYear('expense_date', $year)->sum('amount');

        $kmDeduction = TaxCalculator::kmDeduction($kilometers);
        $netProfit   = TaxCalculator::netProfit($revenue, $expenses, $kmDeduction);

        // --- BTW-reservering voor het lopende kwartaal ---
        $qStart = now()->startOfQuarter();
        $qEnd   = now()->endOfQuarter();

        $vatReceived = (float) $user->shifts()
            ->whereBetween('work_date', [$qStart, $qEnd])
            ->selectRaw('COALESCE(SUM(hours * hourly_rate * vat_rate / 100), 0) as total')
            ->value('total');

        $vatPaid = (float) $user->expenses()
            ->whereBetween('expense_date', [$qStart, $qEnd])
            ->sum('vat_amount');

        $vatReserve = TaxCalculator::vatReserve($vatReceived, $vatPaid);

        // --- Recente activiteit (shifts + ritten door elkaar) ---
        $shiftRows = $user->shifts()->latest('work_date')->take(6)->get()->map(fn ($s) => [
            'type'   => 'shift',
            'date'   => $s->work_date,
            'title'  => $s->client_name,
            'detail' => number_format($s->hours, 2, ',', '.') . ' uur × € ' . number_format($s->hourly_rate, 2, ',', '.'),
            'amount' => $s->amount_excl,
            'badge'  => $s->vat_rate,
        ]);

        $tripRows = $user->trips()->latest('trip_date')->take(6)->get()->map(fn ($t) => [
            'type'   => 'trip',
            'date'   => $t->trip_date,
            'title'  => $t->from_location . ' → ' . $t->to_location,
            'detail' => number_format($t->kilometers, 1, ',', '.') . ' km · ' . $t->vehicle,
            'amount' => $t->deduction,
            'badge'  => null,
        ]);

        $recent = $shiftRows->concat($tripRows)->sortByDesc('date')->take(8)->values();

        return view('dashboard', compact(
            'year', 'revenue', 'hours', 'kilometers', 'expenses', 'kmDeduction',
            'netProfit', 'vatReceived', 'vatPaid', 'vatReserve', 'recent'
        ));
    }
}
