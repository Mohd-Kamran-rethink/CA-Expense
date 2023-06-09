<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function list(Request $req)
    {
        $departments=Department::join('users','departments.user_id', '=', 'users.id')
                        ->select('departments.*','users.name as userName')
                        ->get();
        return view('Admin.Departments.list',compact('departments'));
    }
    public function addForm()
    {
        $managers=User::whereIn('role', ['manager', 'customer_care_manager'])->get();
        return view('Admin.Departments.add',compact('managers'));
    }
    public function add(Request $req)
    {
        $department=new Department();
        $department->user_id=$req->user_id;
        $department->name=$req->name;
        $department->save();
        $user=User::find($req->user_id);
        $user->assigned_department=$department->id;
        $result=$user->update();
        if ($result) {
            return redirect('/departments')->with(['msg-success' => 'Department  has been updated.']);
        } else {
            return redirect('/departments')->with(['msg-error' => 'Something went wrong could not add department .']);
            }
    }
    public function delete(Request $req)
    {
        $department=Department::find($req->deleteId);
        $user=User::find($department->user_id);
        $user->assigned_department=null;
        $user->update();
        $result=$department->delete();
        if ($result) {
            return redirect('/departments')->with(['msg-success' => 'Department  has been deleted.']);
        } else {
            return redirect('/departments')->with(['msg-error' => 'Something went wrong could not delete department .']);
            }
    }
}
