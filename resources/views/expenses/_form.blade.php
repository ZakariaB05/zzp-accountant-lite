@php
    $input = 'mt-1 block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200';
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="title" class="text-sm font-medium text-slate-700">Titel</label>
        <input id="title" name="title" type="text" class="{{ $input }}"
               value="{{ old('title', $expense->title ?? '') }}" required>
        @error('title') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category" class="text-sm font-medium text-slate-700">Categorie</label>
        <select id="category" name="category" class="{{ $input }}">
            @foreach (\App\Models\Expense::CATEGORIES as $category)
                <option value="{{ $category }}" @selected(old('category', $expense->category ?? '') === $category)>{{ $category }}</option>
            @endforeach
        </select>
        @error('category') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="expense_date" class="text-sm font-medium text-slate-700">Datum</label>
        <input id="expense_date" name="expense_date" type="date" class="{{ $input }}"
               value="{{ old('expense_date', isset($expense) ? $expense->expense_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        @error('expense_date') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="amount" class="text-sm font-medium text-slate-700">Bedrag excl. BTW (€)</label>
        <input id="amount" name="amount" type="number" step="0.01" class="{{ $input }}"
               value="{{ old('amount', $expense->amount ?? '') }}" required>
        @error('amount') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="vat_amount" class="text-sm font-medium text-slate-700">BTW-bedrag (€)</label>
        <input id="vat_amount" name="vat_amount" type="number" step="0.01" class="{{ $input }}"
               value="{{ old('vat_amount', $expense->vat_amount ?? '0') }}" required>
        <p class="mt-1 text-xs text-slate-400">De BTW die je terugvraagt. Vul 0 in als er geen BTW is.</p>
        @error('vat_amount') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Opslaan</button>
    <a href="{{ route('expenses.index') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuleren</a>
</div>