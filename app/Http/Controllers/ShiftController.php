<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShiftController extends Controller
{
    public function index(Request $request): View
    {
        $shifts = $request->user()->shifts()->latest('work_date')->paginate(10);

        return view('shifts.index', compact('shifts'));
    }

    public function create(): View
    {
        return view('shifts.create');
    }

    public function store(ShiftRequest $request): RedirectResponse
    {
        $request->user()->shifts()->create($request->validated());

        return redirect()->route('shifts.index')->with('success', 'Shift opgeslagen.');
    }

    public function edit(Shift $shift): View
    {
        $this->checkOwner($shift);

        return view('shifts.edit', compact('shift'));
    }

    public function update(ShiftRequest $request, Shift $shift): RedirectResponse
    {
        $this->checkOwner($shift);
        $shift->update($request->validated());

        return redirect()->route('shifts.index')->with('success', 'Shift bijgewerkt.');
    }

    public function destroy(Shift $shift): RedirectResponse
    {
        $this->checkOwner($shift);
        $shift->delete();

        return redirect()->route('shifts.index')->with('success', 'Shift verwijderd.');
    }

    // Je mag alleen je eigen shifts bekijken of wijzigen
    private function checkOwner(Shift $shift): void
    {
        abort_unless($shift->user_id === auth()->id(), 403);
    }
}