@extends('layouts.zzp')

@section('title', 'Dashboard · ZZP Accountant Lite')

@section('content')
@php $eur = fn ($v) => '€ ' . number_format($v, 2, ',', '.'); @endphp

<div class="mx-auto max-w-6xl space-y-8">

    {{-- Kop --}}
    <header class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Hoi {{ strtok(auth()->user()->name, ' ') }}, dit is je jaar tot nu toe</h1>
            <p class="mt-1 text-sm text-slate-500">Cijfers over {{ $year }}. Bedragen zijn exclusief BTW.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ url('/shifts/create') }}" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Shift toevoegen</a>
            <a href="{{ url('/trips/create') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200">Rit toevoegen</a>
        </div>
    </header>

    {{-- Stat cards --}}
    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        <x-stat-card label="Totale inkomsten" :value="$eur($revenue)" hint="Omzet uit shifts" tone="indigo">
            <path d="M12 8c-2.2 0-4 1-4 2.5S9.8 13 12 13s4 1 4 2.5S14.2 18 12 18m0-12v12M3 12a9 9 0 1018 0 9 9 0 00-18 0z"/>
        </x-stat-card>

        <x-stat-card label="Gewerkte uren" :value="number_format($hours, 1, ',', '.') . ' uur'" hint="Alle geregistreerde shifts" tone="sky">
            <path d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
        </x-stat-card>

        <x-stat-card label="Zakelijke kilometers" :value="number_format($kilometers, 1, ',', '.') . ' km'" :hint="'Aftrekpost ' . $eur($kmDeduction) . ' (€ 0,23 per km)'" tone="amber">
            <path d="M8 17h8M7 13h10l-1.5-5h-7L7 13zm0 0v4m10-4v4"/>
        </x-stat-card>

        <x-stat-card label="Totale onkosten" :value="$eur($expenses)" hint="Zakelijke uitgaven" tone="slate">
            <path d="M17 9V7a4 4 0 00-8 0v2M5 9h14l-1 11H6L5 9z"/>
        </x-stat-card>

        <x-stat-card label="Geschatte nettowinst" :value="$eur($netProfit)" hint="Omzet − (onkosten + km-aftrek)" tone="emerald">
            <path d="M3 17l6-6 4 4 8-8M15 7h6v6"/>
        </x-stat-card>

        {{-- BTW-kaart: iets opvallender --}}
        <div class="rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-800 p-5 text-white shadow-lg">
            <div class="flex items-start justify-between">
                <p class="text-sm font-medium text-indigo-100">BTW-reservering dit kwartaal</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 14l6-6M9.5 8.5h.01M14.5 13.5h.01M5 4h14v16l-3-2-2 2-2-2-2 2-2-2-3 2V4z"/></svg>
                </span>
            </div>
            <p class="mt-3 text-2xl font-bold tracking-tight">{{ $eur($vatReserve) }}</p>
            <p class="mt-1 text-xs text-indigo-100">Ontvangen {{ $eur($vatReceived) }} − betaald {{ $eur($vatPaid) }}</p>
        </div>
    </section>

    {{-- Recente activiteit --}}
    <section class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-md">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-slate-900">Recente shifts en ritten</h2>
        </div>

        @if ($recent->isEmpty())
            <div class="px-6 py-14 text-center">
                <p class="font-semibold text-slate-800">Nog niets geregistreerd</p>
                <p class="mt-1 text-sm text-slate-500">Voeg je eerste shift of rit toe om je cijfers te zien.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold text-slate-500">
                        <tr>
                            <th class="px-6 py-3">Datum</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Omschrijving</th>
                            <th class="px-6 py-3">BTW</th>
                            <th class="px-6 py-3 text-right">Bedrag</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($recent as $row)
                            <tr class="transition hover:bg-indigo-50/40">
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $row['date']->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($row['type'] === 'shift')
                                        <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">Shift</span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Rit</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $row['title'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $row['detail'] }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($row['badge'] === 21)
                                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">21%</span>
                                    @elseif ($row['badge'] === 9)
                                        <span class="rounded-full bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700">9%</span>
                                    @elseif ($row['badge'] === 0)
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">BTW-vrij</span>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-semibold {{ $row['type'] === 'shift' ? 'text-slate-900' : 'text-amber-600' }}">
                                    {{ $eur($row['amount']) }}
                                    @if ($row['type'] === 'trip')<span class="block text-xs font-normal text-slate-400">aftrekpost</span>@endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection
