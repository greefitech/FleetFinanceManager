<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;



class Customer extends Model
{

    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }


    use SoftDeletes;
    
    protected $fillable = ['name', 'mobile', 'address', 'type', 'clientid', 'managerid'];
    protected $guarded = ['id','created_at', 'updated_at'];
    
    protected $dates = ['deleted_at'];

    public function customerEntryData(){
        return $this->hasMany(Entry::class, 'customerId', 'id');
    }

    public function customerIncomeData(){
        return $this->hasMany(Income::class, 'customerId', 'id');
    }

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }


    public static function CreateUpdateCustomer($id=NULL){
        try {
            if ($id){
                $customer = Customer::findorfail($id);
            }else{
                $customer = new Customer;
            }
            $customer->name = request('name');
            $customer->address = request('address');
            $customer->mobile = request('mobile');
            $customer->type = request('type');
            if (!$id && Auth::guard('client')->check()){
                $customer->clientid = auth()->user()->id;
            }else if(!$id && Auth::guard('manager')->check()){
                $customer->clientid = auth()->user()->clientid;
                $customer->managerid = auth()->user()->id;
            }
            $customer->save();
            return 'success';
        }catch (Exception $e){
            return 'error';
        }
    }

    public static function DeleteCustomer($id){
        $EntryCount=Entry::where([['customerId',$id]])->count();
        $IncomeCount=Income::where([['customerId',$id]])->count();
        if($EntryCount>0 ||$IncomeCount>0){
            return back()->with('sorry','Something went wrong! Delete Customer Cause Some Data Loss! Contact Admin!');
        }
        try {
            Customer::findOrfail($id)->delete();
            return back()->with('success',['Customer','Deleted Successfully']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong! Delete Not Allowed!');
        }
    }
}
