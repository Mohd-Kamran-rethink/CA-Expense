<?php

namespace App\Http\Controllers;

use App\Expense;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //NOTE:: There will be 7 roles in the global CA in this project we are only using 5 roles 
    // i.e customer_care_manager,deposit_banker,withdrawal_banker,depositer,withdrawrer 

    // login Form
    public function loginView()
    {
        if (session()->has('user')) {
            return redirect('/dashboard');
        } else {
            return view('Admin.Auth.Login');
        }
    }
    // login validation
    public function login(Request $req)
    {
        // roles allowerd in CA-customer project
        $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', '=',$req->email)->first();
        dd($user);        
        if ($user) {
            if (Hash::check($req->password, $user->password)) {
                session()->put('user', $user);
                return redirect('/dashboard');
            } else {
                return redirect('/')->with(['msg-error-password' => 'Invalid password']);
            }
        } else {
            return redirect('/')->with(['msg-error-username' => "Email is not registered with us"]);
        }
    }
    // logout user 
    public function logout()
    {
        $result = session()->remove('user');
        if ($result) {
            return redirect('/');
        }
    }
    // dashboard to show expense and credits daily, monthly,and total
    public function dashbaod()
    {
        // dates management
        $today = Carbon::now()->format('Y-m-d');
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Retrieve daily expenses in INR
        $dailyExpenseSumINR = Expense::where('user_id', '=', session('user')->id)
            ->where('currency_type', '=', 'rupee')
            ->whereDate('created_at', '=', $today)
            ->sum('amount');

        // Retrieve daily expenses in AED
        $dailyExpenseSumAED = Expense::where('user_id', '=', session('user')->id)
            ->where('currency_type', '=', 'aed')
            ->whereDate('created_at', '=', $today)
            ->sum('amount');

        // Calculate the total daily expense in INR equivalent
        $totalDailyExpense = $dailyExpenseSumINR + ($dailyExpenseSumAED * 22.45);
        // monthy expsene

        // Retrieve monthly expenses in INR
        $monthlyExpenseSumINR = Expense::where('user_id', '=', session('user')->id)
            ->where('currency_type', '=', 'rupee')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        // Retrieve monthly expenses in AED
        $monthlyExpenseSumAED = Expense::where('user_id', '=', session('user')->id)
            ->where('currency_type', '=', 'aed')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        // Calculate the total monthly expenses in INR equivalent
        $totalMonthlyExpense = $monthlyExpenseSumINR + ($monthlyExpenseSumAED * 22.45);
        // total
        // Retrieve monthly expenses in INR
        $TotalExpenseSumINR = Expense::where('user_id', '=', session('user')->id)
            ->where('currency_type', '=', 'rupee')
            ->sum('amount');
        // Retrieve Total expenses in AED
        $TotalExpenseSumAED = Expense::where('user_id', '=', session('user')->id)
            ->where('currency_type', '=', 'aed')
            ->sum('amount');
        // Calculate the total Total expenses in INR equivalent
        $totalExpense = $TotalExpenseSumINR + ($TotalExpenseSumAED * 22.45);

        

        // for super manager
        // Retrieve daily expenses in INR
        $SupdailyExpenseSumINR = Expense::where('currency_type', '=', 'rupee')
            ->whereDate('created_at', '=', $today)
            ->sum('amount');

        // Retrieve daily expenses in AED
        $SupdailyExpenseSumAED = Expense::where('currency_type', '=', 'aed')
            ->whereDate('created_at', '=', $today)
            ->sum('amount');

        // Calculate the total daily expense in INR equivalent
        $SuptotalDailyExpense = $SupdailyExpenseSumINR + ($SupdailyExpenseSumAED * 22.45);

        // Retrieve monthly expenses in INR
        $SupmonthlyExpenseSumINR = Expense::where('currency_type', '=', 'rupee')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        // Retrieve monthly expenses in AED
        $SupmonthlyExpenseSumAED = Expense::where('currency_type', '=', 'aed')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        // Calculate the total monthly expenses in INR equivalent
        $SuptotalMonthlyExpense = $SupmonthlyExpenseSumINR + ($SupmonthlyExpenseSumAED * 22.45);
        // sup
        // Retrieve monthly expenses in INR
        $SupExpenseSumINR = Expense::where('currency_type', '=', 'rupee')
            ->sum('amount');
        // Retrieve monthly expenses in AED
        $SupExpenseSumAED = Expense::where('currency_type', '=', 'aed')
            ->sum('amount');
        // Calculate the total monthly expenses in INR equivalent
        $SuptotalExpense = $SupExpenseSumINR + ($SupExpenseSumAED * 22.45);
        return view('Admin.Dashboard.index', compact('SuptotalExpense','SuptotalDailyExpense', 'SuptotalMonthlyExpense', 'totalExpense', 'totalDailyExpense', 'totalMonthlyExpense'));
    }
}
