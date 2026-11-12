@extends('layouts.zzp')

@section('title', 'Shifts')

@section('content')
@php $eur = fn ($v) => '€ ' . number_format($v, 2, ',', '.'); @endphp

<div class="mx-auto max-w-6xl space-y-6">
    <header class="flex items-center justify-between gap-4">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Shifts</h1>
        <a href="{{ route('shifts.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Shift toevoegen</a>
    </header>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-md">
        @if ($shifts->isEmpty())
            <div class="px-6 py-14 text-center">
                <p class="font-semibold text-slate-800">Nog geen shifts</p>
                <p class="mt-1 text-sm text-slate-500">Voeg je eerste shift toe om je omzet bij te houden.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold text-slate-500">
                        <tr>
                            <th class="px-6 py-3">Datum</th>
                            <th class="px-6 py-3">Opdrachtgever</th>
                            <th class="px-6 py-3">Uren</th>
                            <th class="px-6 py-3">Tarief</th>
                            <th class="px-6 py-3">BTW</th>
                            <th class="px-6 py-3 text-right">Excl. BTW</th>
                            <th class="px-6 py-3 text-right">Incl. BTW</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($shifts as $shift)
                            <tr class="transition hover:bg-indigo-50/40">
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $shift->work_date->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $shift->client_name }}</td>
                                <td class="px-6 py-4">{{ number_format($shift->hours, 2, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $eur($shift->hourly_rate) }}</td>
                                <td class="px-6 py-4">
                                    @if ($shift->vat_rate === 21)
                                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">21%</span>
                                    @elseif ($shift->vat_rate === 9)
                                        <span class="rounded-full bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700">9%</span>
                                    @else
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">BTW-vrij</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">{{ $eur($shift->amount_excl) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-slate-900">{{ $eur($shift->amount_incl) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a href="{{ route('shifts.edit', $shift) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Bewerken</a>
                                    <form method="POST" action="{{ route('shifts.destroy', $shift) }}" class="ml-3 inline"
                                          onsubmit="return confirm('Weet je zeker dat je deze shift wilt verwijderen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm font-semibold text-rose-600 hover:text-rose-800">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-6 py-4">{{ $shifts->links() }}</div>
        @endif
    </div>
</div>
@endsection