@php
    $input = 'mt-1 block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200';
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="trip_date" class="text-sm font-medium text-slate-700">Datum</label>
        <input id="trip_date" name="trip_date" type="date" class="{{ $input }}"
               value="{{ old('trip_date', isset($trip) ? $trip->trip_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        @error('trip_date') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="vehicle" class="text-sm font-medium text-slate-700">Voertuig</label>
        <input id="vehicle" name="vehicle" type="text" list="vehicles" class="{{ $input }}"
               value="{{ old('vehicle', $trip->vehicle ?? 'Auto') }}" required>
        <datalist id="vehicles">
            <option value="Auto"><option value="Motor"><option value="Bestelbus">
        </datalist>
        @error('vehicle') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="from_location" class="text-sm font-medium text-slate-700">Van</label>
        <input id="from_location" name="from_location" type="text" class="{{ $input }}"
               value="{{ old('from_location', $trip->from_location ?? '') }}" required>
        @error('from_location') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="to_location" class="text-sm font-medium text-slate-700">Naar</label>
        <input id="to_location" name="to_location" type="text" class="{{ $input }}"
               value="{{ old('to_location', $trip->to_location ?? '') }}" required>
        @error('to_location') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="kilometers" class="text-sm font-medium text-slate-700">Aantal kilometers</label>
        <input id="kilometers" name="kilometers" type="number" step="0.1" class="{{ $input }}"
               value="{{ old('kilometers', $trip->kilometers ?? '') }}" required>
        <p class="mt-1 text-xs text-slate-400">De aftrekpost wordt automatisch berekend (€ 0,23 per km).</p>
        @error('kilometers') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Opslaan</button>
    <a href="{{ route('trips.index') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuleren</a>
</div>