@extends('layouts.zzp')

@section('title', 'Onkost toevoegen')

@section('content')
<div class="mx-auto max-w-2xl">
    <h1 class="mb-6 text-2xl font-extrabold tracking-tight text-slate-900">Onkost toevoegen</h1>
    <form method="POST" action="{{ route('expenses.store') }}" class="rounded-2xl border border-slate-100 bg-white p-6 shadow-md">
        @csrf
        @include('expenses._form')
    </form>
</div>
@endsection