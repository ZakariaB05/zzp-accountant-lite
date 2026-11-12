<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripRequest;
use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(Request $request): View
    {
        $trips = $request->user()->trips()->latest('trip_date')->paginate(10);

        return view('trips.index', compact('trips'));
    }

    public function create(): View
    {
        return view('trips.create');
    }

    public function store(TripRequest $request): RedirectResponse
    {
        $request->user()->trips()->create($request->validated());

        return redirect()->route('trips.index')->with('success', 'Rit opgeslagen.');
    }

    public function edit(Trip $trip): View
    {
        $this->checkOwner($trip);

        return view('trips.edit', compact('trip'));
    }

    public function update(TripRequest $request, Trip $trip): RedirectResponse
    {
        $this->checkOwner($trip);
        $trip->update($request->validated());

        return redirect()->route('trips.index')->with('success', 'Rit bijgewerkt.');
    }

    public function destroy(Trip $trip): RedirectResponse
    {
        $this->checkOwner($trip);
        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Rit verwijderd.');
    }

    private function checkOwner(Trip $trip): void
    {
        abort_unless($trip->user_id === auth()->id(), 403);
    }
}