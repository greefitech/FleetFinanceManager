<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomeControllers extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function getClientDetails(){
        return 1;
    }
}
