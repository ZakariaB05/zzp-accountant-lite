@php
    $input = 'mt-1 block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200';
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="client_name" class="text-sm font-medium text-slate-700">Opdrachtgever</label>
        <input id="client_name" name="client_name" type="text" class="{{ $input }}"
               value="{{ old('client_name', $shift->client_name ?? '') }}" required>
        @error('client_name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="work_date" class="text-sm font-medium text-slate-700">Datum</label>
        <input id="work_date" name="work_date" type="date" class="{{ $input }}"
               value="{{ old('work_date', isset($shift) ? $shift->work_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        @error('work_date') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="hours" class="text-sm font-medium text-slate-700">Gewerkte uren</label>
        <input id="hours" name="hours" type="number" step="0.25" class="{{ $input }}"
               value="{{ old('hours', $shift->hours ?? '') }}" required>
        @error('hours') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="hourly_rate" class="text-sm font-medium text-slate-700">Uurtarief (€)</label>
        <input id="hourly_rate" name="hourly_rate" type="number" step="0.01" class="{{ $input }}"
               value="{{ old('hourly_rate', $shift->hourly_rate ?? '') }}" required>
        @error('hourly_rate') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="vat_rate" class="text-sm font-medium text-slate-700">BTW-tarief</label>
        <select id="vat_rate" name="vat_rate" class="{{ $input }}">
            @foreach ([21 => '21%', 9 => '9%', 0 => 'BTW-vrij (0%)'] as $value => $label)
                <option value="{{ $value }}" @selected((int) old('vat_rate', $shift->vat_rate ?? 21) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('vat_rate') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
        Opslaan
    </button>
    <a href="{{ route('shifts.index') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuleren</a>
</div>