<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $expenses = $request->user()->expenses()->latest('expense_date')->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    public function create(): View
    {
        return view('expenses.create');
    }

    public function store(ExpenseRequest $request): RedirectResponse
    {
        $request->user()->expenses()->create($request->validated());

        return redirect()->route('expenses.index')->with('success', 'Onkost opgeslagen.');
    }

    public function edit(Expense $expense): View
    {
        $this->checkOwner($expense);

        return view('expenses.edit', compact('expense'));
    }

    public function update(ExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $this->checkOwner($expense);
        $expense->update($request->validated());

        return redirect()->route('expenses.index')->with('success', 'Onkost bijgewerkt.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->checkOwner($expense);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Onkost verwijderd.');
    }

    private function checkOwner(Expense $expense): void
    {
        abort_unless($expense->user_id === auth()->id(), 403);
    }
}