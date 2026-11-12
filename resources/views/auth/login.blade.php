<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">ZZP Accountant Lite</h1>
        <p class="mt-1 text-sm text-slate-500">Log in om je uren, kilometers en onkosten te bekijken.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="E-mailadres" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Wachtwoord" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Onthoud mij</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                Inloggen
            </button>
        </div>

        @if (Route::has('password.request'))
            <p class="mt-4 text-center">
                <a class="text-sm text-slate-500 underline hover:text-slate-800" href="{{ route('password.request') }}">Wachtwoord vergeten?</a>
            </p>
        @endif
    </form>

    @if (Route::has('register'))
        <div class="mt-6 border-t border-slate-100 pt-6 text-center">
            <p class="text-sm text-slate-500">Nog geen account?</p>
            <a href="{{ route('register') }}" class="mt-2 inline-block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200">
                Account aanmaken
            </a>
        </div>
    @endif
</x-guest-layout>