@props(['label', 'value', 'hint' => null, 'tone' => 'indigo'])

@php
    $tones = [
        'indigo'  => 'bg-indigo-50 text-indigo-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'sky'     => 'bg-sky-50 text-sky-600',
        'amber'   => 'bg-amber-50 text-amber-600',
        'slate'   => 'bg-slate-100 text-slate-600',
    ];
@endphp

<div class="rounded-2xl border border-slate-100 bg-white/80 p-5 shadow-md backdrop-blur transition hover:shadow-lg">
    <div class="flex items-start justify-between">
        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $tones[$tone] ?? $tones['indigo'] }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                {{ $slot }}
            </svg>
        </span>
    </div>
    <p class="mt-3 text-2xl font-bold tracking-tight text-slate-900">{{ $value }}</p>
    @if ($hint)
        <p class="mt-1 text-xs text-slate-400">{{ $hint }}</p>
    @endif
</div>
