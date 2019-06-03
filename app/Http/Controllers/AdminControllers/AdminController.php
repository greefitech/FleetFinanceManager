<?php

namespace App\Http\Controllers\AdminControllers;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @property  Admin
 */
class AdminController extends Controller
{
    public function Viewadminaccount(){
        $Data['admins']=Admin::get();
        return view('admin.users.view',$Data);
    }

    public function addadminaccount(){
        return view('admin.users.add');
    }

    public function SaveadminAccount(){
//        return request()->all();
        $this->validate(request(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6',
            'mobile' => 'required|min:10|max:10|unique:admins',
        ]);
        try {
        Admin::create([
            'name' => request('name'),
            'email' => request('email'),
            'remember_token' => request('remember'),
            'password' => bcrypt(request('password')),
            'mobile' => request('mobile'),
        ]);
            return back()->with('success',['Admin','Added Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }
}
