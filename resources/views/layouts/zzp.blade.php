<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ZZP Accountant Lite')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui'] } } } }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-indigo-50/60 font-sans text-slate-700 antialiased">

@php
    $nav = [
        ['Dashboard', url('/dashboard'), request()->is('dashboard'), 'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10'],
        ['Shifts',    url('/shifts'),    request()->is('shifts*'),   'M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z'],
        ['Ritten',    url('/trips'),     request()->is('trips*'),    'M8 17h8M7 13h10l-1.5-5h-7L7 13zm0 0v4m10-4v4'],
        ['Onkosten',  url('/expenses'),  request()->is('expenses*'), 'M17 9V7a4 4 0 00-8 0v2M5 9h14l-1 11H6L5 9z'],
    ];
@endphp

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="hidden w-64 shrink-0 flex-col border-r border-slate-200/70 bg-white/70 p-5 backdrop-blur lg:flex">
        <div class="mb-8 flex items-center gap-3 px-2">
            <a href="{{ route('profile-photo.edit') }}" title="Profielfoto wijzigen" class="shrink-0">
    @if (auth()->user()->profile_photo_url)
        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profielfoto" class="h-10 w-10 rounded-full object-cover shadow-md ring-2 ring-white">
    @else
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-lg font-extrabold text-white shadow-md">Z</div>
    @endif
</a>
            <div>
                <p class="text-sm font-bold leading-tight text-slate-900">ZZP Accountant</p>
                <p class="text-xs text-slate-400">Lite</p>
            </div>
        </div>

        <nav class="space-y-1">
            @foreach ($nav as [$label, $href, $active, $icon])
                <a href="{{ $href }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                          {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
            <p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
            <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button class="rounded text-xs font-semibold text-indigo-600 hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-300">Uitloggen</button>
            </form>
        </div>
    </aside>

    {{-- Content --}}
    <main class="min-w-0 flex-1 p-5 sm:p-8">
        @yield('content')
    </main>
</div>

</body>
</html>
