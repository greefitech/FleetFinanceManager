<?php

namespace App\Http\Controllers\ClientController;

use App\Manager;
use App\ManagerLorry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function view(){
        return view('client.setting.manager.view');
    }

    public function add(){
        return view('client.setting.manager.add');
    }

    public function save(){
        $this->validate(request(),[
            'name'=>'required',
            'password' => 'required|min:6|confirmed',
            'mobile' => 'required|min:10|max:10',
            'email' => 'required|email',
        ]);
        if(Manager::where([['clientid',auth()->user()->id],['email',request('email')]])->first()){
            return back()->withInput()->withErrors(['email'=>['Email Already Added']]);
        }
        if(Manager::where([['clientid',auth()->user()->id],['mobile',request('mobile')]])->first()){
            return back()->withInput()->withErrors(['mobile'=>['Mobile Already Added']]);
        }
        try{
            $manager = new Manager;
            $manager->name = request('name');
            $manager->email = request('email');
            $manager->mobile = request('mobile');
            $manager->password = bcrypt(request('password'));
            $manager->clientid = auth()->user()->id;
            $manager->save();
            if(!empty(request('manager_vehicle_id'))){
                foreach (request('manager_vehicle_id') as $MangerLorry){
                    $ManagerLorry = new ManagerLorry;
                    $ManagerLorry->vehicleId = $MangerLorry;
                    $ManagerLorry->manager_login_id = $manager->id;
                    $ManagerLorry->save();
                }
            }
            return redirect(route('client.ViewManagers'))->with('success',['Manager','Created Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try{
            $Data['Manager'] = Manager::findorfail($id);
            if ($Data['Manager']->clientid == auth()->user()->id){
                return view('client.setting.manager.edit',$Data);
            }else{
                return back();
            }
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'name'=>'required',
            'password' => 'nullable|min:6|confirmed',
            'mobile' => 'required|min:10|max:10',
            'email' => 'required|email',
        ]);
        if(Manager::where([['clientid',auth()->user()->id],['email',request('email')],['id','!=',$id]])->first()){
            return back()->withInput()->withErrors(['email'=>['Email Already Added']]);
        }
        if(Manager::where([['clientid',auth()->user()->id],['mobile',request('mobile')],['id','!=',$id]])->first()){
            return back()->withInput()->withErrors(['mobile'=>['Mobile Already Added']]);
        }
        try{
            $manager = Manager::findorfail($id);
            $manager->name = request('name');
            $manager->email = request('email');
            $manager->mobile = request('mobile');
            if(!empty(request('password'))){
                $manager->password = bcrypt(request('password'));
            }
            $manager->clientid = Auth::user()->id;
            $manager->save();
            if(!empty(request('manager_vehicle_id'))){
                foreach (request('manager_vehicle_id') as $MangerLorry){
                    if(!in_array($MangerLorry,$manager->ManagerLorries())){
                        $ManagerLorry = new ManagerLorry;
                        $ManagerLorry->vehicleId = $MangerLorry;
                        $ManagerLorry->manager_login_id = $manager->id;
                        $ManagerLorry->save();
                    }
                }
                foreach ($manager->ManagerLorries() as $MangerLorryDelete){
                    if(!in_array($MangerLorryDelete,request('manager_vehicle_id'))){
                        ManagerLorry::where([['vehicleId',$MangerLorryDelete],['manager_login_id',$manager->id]])->delete();
                    }
                }
            }else{
                ManagerLorry::where('manager_login_id',$manager->id)->delete();
            }
            return redirect(route('client.ViewManagers'))->with('success',['Manager','Updated Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
