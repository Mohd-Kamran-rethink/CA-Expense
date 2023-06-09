<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreditsController extends Controller
{
    // total credits 
    public function list(Request $req)
    {
        $startDate = $req->query('from_date') ?? null;
        $endDate = $req->query('to_date') ?? null;
        $expense_type = $req->query('expense_type') ?? null;
        $transaction_type = $req->query('transaction_type') ?? null;
        $currency = $req->query('currency') ?? null;
        $created_from_date = $req->query('created_from_date');
        if (!$startDate) {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } else {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();
        }

        // query
        $credits = Expense::join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->join('departments', 'expenses.department_id', '=', 'departments.id')
            ->select('expenses.*', 'departments.name as departmenName', 'expense_types.name as expenseType')
            ->where('creditor_id', '=', session('user')->id)
            // conditional
            ->when($expense_type, function ($query, $expense_type) {
                $query->where(function ($query) use ($expense_type) {
                    $query->Where('expenses.expense_type_id', '=', $expense_type);
                });
            })
            ->when($transaction_type, function ($query, $transaction_type) {
                $query->where(function ($query) use ($transaction_type) {
                    $query->Where('expenses.transaction_type', '=', $transaction_type);
                });
            })
            ->when($currency, function ($query, $currency) {
                $query->where(function ($query) use ($currency) {
                    $query->Where('expenses.currency_type', '=', $currency);
                });
            })
            ->whereDate('expenses.created_at', '>=', date('Y-m-d', strtotime($startDate)))
            ->whereDate('expenses.created_at', '<=', date('Y-m-d', strtotime($endDate)))
            ->get();
        $expenseTypes = ExpenseType::get();
        $startDate = $startDate->toDateString();
        $endDate = $endDate->toDateString();
        return view('Admin.Credits.list', compact('endDate', 'startDate', 'currency', 'transaction_type', 'expense_type', 'expenseTypes', 'credits'));
    }
}
