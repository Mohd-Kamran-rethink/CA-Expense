<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankDetail;
use App\Department;
use App\Expense;
use App\ExpenseType;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // list expense type
    public function list(Request $req)
    {
        $expenses = ExpenseType::orderBy('name', 'asc')->get();
        $department = Department::where('user_id', session('user')->id)->first();
        return view('Admin.ExpenseType.list', compact('expenses', 'department'));
    }
    // delelte expense type
    public function delete(Request $req)
    {
        $expese = ExpenseType::find($req->deleteId);
        $result = $expese->delete();
        if ($result) {
            return redirect('/expense-type')->with(['msg-success' => 'Expense type has been deleted.']);
        } else {
            return redirect('/expense-type')->with(['msg-error' => 'Something went wrong could not delete source.']);
        }
    }
    // add form expense type
    public function addForm()
    {
        $department = Department::where('user_id', session('user')->id)->first();
        return view('Admin.ExpenseType.add', compact('department'));
    }
    // edit form expense type 
    public function editForm(Request $req)
    {
        $id = $req->query('id');
        $department = Department::where('user_id', session('user')->id)->first();
        $expenseType = ExpenseType::find($id);
        return view('Admin.ExpenseType.add', compact('expenseType', 'department'));
    }
    // add expense-type
    public function add(Request $req)
    {
        $user = session('user');
        $expenseTYpe = new ExpenseType();
        $expenseTYpe->name = $req->name;
        $expenseTYpe->department_id = $user->assigned_department;
        $result = $expenseTYpe->save();
        if ($result) {
            return redirect('/expense-type')->with(['msg-success' => 'Expense type has been added.']);
        } else {
            return redirect('/expense-type')->with(['msg-error' => 'Something went wrong could not add expense type.']);
        }
    }
    // edit expense types
    public function edit(Request $req)
    {
        $expenseTYpe = ExpenseType::find($req->expenseTypeId);;
        $expenseTYpe->name = $req->name;
        $result = $expenseTYpe->save();
        if ($result) {
            return redirect('/expense-type')->with(['msg-success' => 'Expense type has been updated.']);
        } else {
            return redirect('/expense-type')->with(['msg-error' => 'Something went wrong could not update expense type.']);
        }
    }
    // expesesses
    public function listMyExpenses(Request $req)
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
        $expenses  = Expense::leftjoin('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->leftjoin('departments', 'expenses.department_id', '=', 'departments.id')
            ->select('expenses.*', 'departments.name as departmenName', 'expense_types.name as expenseType')
            ->where('expenses.user_id', '=', session('user')->id)
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
        return view('Admin.Expenses.list', compact('endDate', 'startDate', 'currency', 'transaction_type', 'expense_type', 'expenseTypes', 'expenses'));
    }
    // add expense form
    public function addExpenseForm()
    {
        $expenseTypes = ExpenseType::orderBy('expense_types.name', 'asc')->get();
        $departments = Department::orderBy('departments.name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        $banks = BankDetail::orderBy('holder_name', 'asc')->get();
        return view('Admin.Expenses.add', compact('banks', 'users', 'departments', 'expenseTypes'));
    }
    // add expenses main function
    public function addExpense(Request $req)
    {
        $expense = new Expense();
        $expense->user_id = session('user')->id;
        $expense->main_type = $req->main_type;
        $expense->transfer_type = $req->transfer_type;
        $expense->sender_bank = $req->sender_bank;
        $expense->receiver_bank = $req->receiver_bank;
        $expense->department_id = $req->department_id;
        $expense->expense_type_id = $req->expensse_type;
        $expense->transaction_type = $req->transactionType;
        $expense->currency_type = $req->currency;
        $expense->creditor_id = $req->creditor_id;
        $expense->amount = $req->amount;
        $expense->remark = $req->remark;
        if ($req->file('attatchement')) {
            // Get filename with the extension
            $filenameWithExt = $req->file('attatchement')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $req->file('attatchement')->getClientOriginalExtension();
            // Filename to store
            $Image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $req->file('attatchement')->storeAs('public/Expense/Attachemnt', $Image);
            $expense->attatchement = $Image;
        }
        $result = $expense->save();
        if ($result) {
            return redirect('/expenses')->with(['msg-success' => 'Expense  has been updated.']);
        } else {
            return redirect('/expenses')->with(['msg-error' => 'Something went wrong could not update expense .']);
        }
    }
    // delete expenses
    public function deleteExpense(Request $req)
    {
        $expense = Expense::find($req->deleteId);
        $result = $expense->delete();
        if ($result) {
            return redirect('/expenses')->with(['msg-success' => 'Expense  has been deleted.']);
        } else {
            return redirect('/expenses')->with(['msg-error' => 'Something went wrong could not delete expense .']);
        }
    }
    // ajax render expense types
    public function renderExpensesType(Request $req)
    {
        if ($req->ajax()) {
            $html = '';
            $expenseTypes = ExpenseType::where('department_id', '=', $req->department)->get();
            $html = '<label>Expense Type<span style="color:red">*</span></label>
              <select  name="expensse_type" id="expense-type" class="form-control searchOptions">
            <option value="0">--Choose--</option>';

            foreach ($expenseTypes as $type) {
                $html .= '<option value=' . $type->id . '>' . $type->name . '</option>';
            }
            '</select>';
            return $html;
        }
    }
    // donwnload attatchement
    public function downloadAttatchment($id)
    {
        $expense = Expense::find($id);
        $file = public_path('storage/Expense/Attachemnt/' . $expense->attatchement);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        return response()->download($file, $expense->attatchement, $headers);
    }


    // creditors
    public function creditors()
    {
        $users = User::where('is_admin', "=", 'No')->get();
        return view('Admin.ExpenseUsers.creditors', compact('users'));
    }
    public function debitors()
    {
        $users = User::where('role', "!=", 'manager')->where('role', "!=", 'customer_care_manager')->where('role', '=', 'expense_debitors')->get();
        return view('Admin.ExpenseUsers.debitors', compact('users'));
    }

    public function creditorsAddFrom()
    {
        return view('Admin.ExpenseUsers.Add');
    }
    public function creditorAdd(Request $req)
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->role = 'expense_creditor';
        $result = $user->save();
        if ($result) {
            return redirect('/expense-users/creditors')->with(['msg-success' => 'Creditor  has been added Successfully.']);
        } else {
            return redirect('/expense-users/creditors')->with(['msg-error' => 'Something went wrong could not add creditors .']);
        }
    }

    public function debitorsAddFrom()
    {
        return view('Admin.ExpenseUsers.AddDebitor');
    }
    public function debitorAdd(Request $req)
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->role = 'expense_debitors';
        $result = $user->save();
        if ($result) {
            return redirect('/expense-users/debitors')->with(['msg-success' => 'Debitor  has been added Successfully.']);
        } else {
            return redirect('/expense-users/debitors')->with(['msg-error' => 'Debitor    went wrong could not add creditors .']);
        }
    }
}
