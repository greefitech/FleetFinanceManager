<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TyreController extends Controller
{
    public function view(){
        return view('client.master.tyre.view');
    }

    public function add(){
        return view('client.master.tyre.add');
    }
}
