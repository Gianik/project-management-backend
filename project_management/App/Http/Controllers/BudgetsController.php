<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budgets;

class BudgetsController extends Controller
{
    public function budgetList()
    {
        $budget = Budgets::with('project.user')->get();
        if (count($budget) > 0) {
            return response()->json(['data' => $budget]);
        } else {
            return response()->json([
                'message' => 'No projects found'
            ], 401);
        }
    }
    public function editBudget(Request $request, $budgetId)
    {
        $budget = Budgets::find($budgetId);
        if ($budget->original_budget == 0 && $budget->current_budget == 0 && $budget->remaining_budget == 0) {
            $budgetArray = array(
                'remaining_budget' => $request->budget,
                'original_budget' => $request->budget,
                'current_budget' => $request->budget
            );
            Budgets::where('id', $budgetId)->update($budgetArray);

            return response()->json(['message' => 'Update Successful']);
        } elseif ($budget->current_budget > $request->budget) {
            $diffirence = $budget->current_budget - $request->budget;
            $current = $budget->remaining_budget - $diffirence;
            $budgetArray = array(
                'current_budget' => $request->budget,
                'remaining_budget' => $current
            );
            Budgets::where('id', $budgetId)->update($budgetArray);
            return response()->json(['message' => 'Update Successful']);
        } elseif ($budget->current_budget < $request->budget) {

            $diffirence = $request->budget - $budget->current_budget;
            $current = $budget->remaining_budget + $diffirence;
            $budgetArray = array(
                'current_budget' => $request->budget,
                'remaining_budget' => $current
            );
            Budgets::where('id', $budgetId)->update($budgetArray);
            return response()->json(['message' => 'Update Successful']);
        }
    }


    public function show($budgetId)
    {
        $budget = Budgets::where('id', $budgetId)->withCount('expenses')->with('expenses.user')->with('project.users')->first();
        if ($budget) {
            return response()->json([$budget]);
        }

        return response()->json(['message' => 'Budget details not found!'], 404);
    }
}
