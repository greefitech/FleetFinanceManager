<?php

namespace App\Http\Controllers\ManagerController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function home(){
        return view('manager.home');
    }

}
