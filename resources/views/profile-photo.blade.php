@extends('layouts.zzp')

@section('title', 'Profielfoto')

@section('content')
<div class="mx-auto max-w-xl">
    <h1 class="mb-6 text-2xl font-extrabold tracking-tight text-slate-900">Profielfoto</h1>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-md">
        <div class="flex items-center gap-5">
            @if (auth()->user()->profile_photo_url)
                <img id="preview" src="{{ auth()->user()->profile_photo_url }}" alt="Profielfoto" class="h-24 w-24 rounded-full object-cover shadow-md ring-4 ring-indigo-50">
            @else
                <div id="placeholder" class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 text-3xl font-extrabold text-white shadow-md">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <img id="preview" src="" alt="Voorbeeld" class="hidden h-24 w-24 rounded-full object-cover shadow-md ring-4 ring-indigo-50">
            @endif
            <div>
                <p class="font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="text-sm text-slate-400">JPG, PNG of WEBP, maximaal 2 MB</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile-photo.update') }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            <label for="photo" class="text-sm font-medium text-slate-700">Kies een foto</label>
            <input id="photo" name="photo" type="file" accept="image/png,image/jpeg,image/webp"
                   class="mt-1 block w-full rounded-xl border border-slate-200 text-sm text-slate-600 file:mr-4 file:rounded-l-xl file:border-0 file:bg-indigo-50 file:px-4 file:py-2.5 file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
            @error('photo') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror

            <div class="mt-6 flex gap-3">
                <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Opslaan</button>
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Terug</a>
            </div>
        </form>

        @if (auth()->user()->profile_photo_url)
            <form method="POST" action="{{ route('profile-photo.destroy') }}" class="mt-4 border-t border-slate-100 pt-4"
                  onsubmit="return confirm('Je profielfoto verwijderen?')">
                @csrf
                @method('DELETE')
                <button class="text-sm font-semibold text-rose-600 hover:text-rose-800">Foto verwijderen</button>
            </form>
        @endif
    </div>
</div>

<script>
    // Toon direct een voorbeeld van de gekozen foto
    document.getElementById('photo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        const placeholder = document.getElementById('placeholder');
        if (placeholder) placeholder.classList.add('hidden');
    });
</script>
@endsection