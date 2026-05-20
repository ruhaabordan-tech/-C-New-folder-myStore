<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store_DailyExpenseRequest;
use App\Models\DailyExpense;
use App\Http\Requests\StoreDailyExpenseRequest;
use App\Http\Requests\UpdateDailyExpenseRequest;

class DailyExpenseController extends Controller
{
    
    public function index()
    {
        return response()->json(DailyExpense::all(),200);
    }

    
    public function store(StoreDailyExpenseRequest $request)
    {
        $expense = DailyExpense::create($request->validated());

        return response()->json([
            'message' => 'Expense created successfully',
            'data' => $expense
        ],201);
    }

    
    public function show(string $id)
    {
        $expense = DailyExpense::findOrFail($id);

        return response()->json($expense,200);
    }

    
    public function update(UpdateDailyExpenseRequest $request,string $id)
    {
        $expense = DailyExpense::findOrFail($id);

        $expense->update($request->validated());

        return response()->json([
            'message' => 'Expense updated successfully',
            'data' => $expense
        ],200);
    }

    
    public function destroy(string $id)
    {
        $expense = DailyExpense::findOrFail($id);

        $expense->delete();

        return response()->json([
            'message' => 'Expense deleted successfully'
        ],200);
    }
}