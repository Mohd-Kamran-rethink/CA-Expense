<?php

namespace App\Http\Controllers;

use App\PettyCash;
use Illuminate\Http\Request;

class PettcashController extends Controller
{
    public function list() 
    {
        $pettyCash=PettyCash::get();
        return view('Admin.PettyCash.list',compact('pettyCash'));    
    }
    public function addForm() {
        return view('Admin.PettyCash.add');    
    }
}
