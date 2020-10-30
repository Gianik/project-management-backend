<?php

namespace App\Http\Controllers;

use App\Expenses;
use Illuminate\Http\Request;
use App\Budgets;
use Illuminate\Support\Carbon;

class ExpensesController extends Controller
{
    public function addExpenses(Request $request)
    {
        $date_today = Carbon::now();
        $expenses = Expenses::create([
            'name' => $request->name,
            'budget_id' => $request->id,
            'expenses_price' => $request->price,
            'user_id' => $request->userId,
            'expenses_date' => $date_today

        ]);
        $budget = Budgets::find($request->id);
        $difference = $budget->remaining_budget - $request->price;
        $budgetArray = array(
            'remaining_budget' => $difference
        );
        Budgets::where('id', $request->id)->update($budgetArray);
        return response()->json(['message' => 'Add Successful']);
    }
    public function editExpenses(Request $request, $expensesId)
    {
        $expenses = Expenses::find($expensesId);
        $budget = Budgets::find($request->id);
        $difference = ($budget->remaining_budget + $expenses->expenses_price) - $request->price;
        $expensesArray = array(
            'name' => $request->name,
            'expenses_price' => $request->price
        );
        Expenses::where('id', $expensesId)->update($expensesArray);
        $budgetArray = array(
            'remaining_budget' => $difference
        );
        Budgets::where('id', $request->id)->update($budgetArray);
    }
    public function deleteExpenses($expensesId, $budgetId)
    {
        $expenses = Expenses::find($expensesId);
        $budget = Budgets::find($budgetId);
        if ($expenses != null) {
            $difference = ($budget->remaining_budget + $expenses->expenses_price);
            $budgetArray = array(
                'remaining_budget' => $difference
            );
            Budgets::where('id', $budgetId)->update($budgetArray);
            $expenses->delete();
            return response()->json(['message' => 'delete successful']);
        } else {
            return response()->json(['message' => 'delete failed']);
        }
    }
}
