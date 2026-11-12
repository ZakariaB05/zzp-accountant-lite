@extends('layouts.zzp')

@section('title', 'Shift bewerken')

@section('content')
<div class="mx-auto max-w-2xl">
    <h1 class="mb-6 text-2xl font-extrabold tracking-tight text-slate-900">Shift bewerken</h1>
    <form method="POST" action="{{ route('shifts.update', $shift) }}" class="rounded-2xl border border-slate-100 bg-white p-6 shadow-md">
        @csrf
        @method('PUT')
        @include('shifts._form')
    </form>
</div>
@endsection