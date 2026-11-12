@extends('layouts.zzp')

@section('title', 'Onkosten')

@section('content')
@php
    $eur = fn ($v) => '€ ' . number_format($v, 2, ',', '.');
    $badge = [
        'Apparatuur' => 'bg-indigo-50 text-indigo-700',
        'Reiskosten' => 'bg-amber-50 text-amber-700',
        'Software'   => 'bg-sky-50 text-sky-700',
    ];
@endphp

<div class="mx-auto max-w-6xl space-y-6">
    <header class="flex items-center justify-between gap-4">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Onkosten</h1>
        <a href="{{ route('expenses.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Onkost toevoegen</a>
    </header>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-md">
        @if ($expenses->isEmpty())
            <div class="px-6 py-14 text-center">
                <p class="font-semibold text-slate-800">Nog geen onkosten</p>
                <p class="mt-1 text-sm text-slate-500">Voeg je eerste zakelijke uitgave toe.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold text-slate-500">
                        <tr>
                            <th class="px-6 py-3">Datum</th>
                            <th class="px-6 py-3">Titel</th>
                            <th class="px-6 py-3">Categorie</th>
                            <th class="px-6 py-3 text-right">Bedrag excl. BTW</th>
                            <th class="px-6 py-3 text-right">BTW</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($expenses as $expense)
                            <tr class="transition hover:bg-indigo-50/40">
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $expense->expense_date->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $expense->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $badge[$expense->category] ?? 'bg-slate-100 text-slate-600' }}">{{ $expense->category }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-slate-900">{{ $eur($expense->amount) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-slate-500">{{ $eur($expense->vat_amount) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Bewerken</a>
                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="ml-3 inline"
                                          onsubmit="return confirm('Weet je zeker dat je deze onkost wilt verwijderen?')">
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
            <div class="border-t border-slate-100 px-6 py-4">{{ $expenses->links() }}</div>
        @endif
    </div>
</div>
@endsection