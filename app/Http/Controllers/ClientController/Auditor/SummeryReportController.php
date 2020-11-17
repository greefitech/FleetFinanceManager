<?php

namespace App\Http\Controllers\ClientController\Auditor;

use App\Account;
use App\AuditorExpenseCategory;
use App\Entry;
use App\Expense;
use App\ExtraIncome;
use App\Income;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SummeryReportController extends Controller
{
    public function index(){
        $Data['Vehicles']=Vehicle::where([['clientid',auth()->user()->id]])->get();
        return view('client.auditor.report.summery.index',$Data);
    }

    public function DownloadReport(){
        $this->validate(request(),[
            'vechile_id'=>'required',
            'date_from'=>'required|date',
            'date_to'=>'required|date',
        ]);
        $AuditorExpenseCategories =  AuditorExpenseCategory::where([['clientid',auth()->user()->id],['type','expense']])->join('auditor_expense_types','auditor_expense_types.auditor_expense_category_id','=','auditor_expense_categories.id')->get()->groupBy('category');
        foreach($AuditorExpenseCategories as $key=>$AuditorExpenseCategory){
            $ExpenseDatas =  Expense::where([['clientid',auth()->user()->id]])->whereIn('expense_type',$AuditorExpenseCategory->pluck('expense_type_id'))->whereIn('vehicleId',request('vechile_id'))->whereBetween('date', [request('date_from'), request('date_to')])->get()->groupBy('account_id')->map(function ($row) {
                return $row->sum('amount');
            });
            $Data['expense'][$key]['amount'] = $ExpenseDatas->toArray();
        }
        $Data['Vehicles'] = Vehicle::whereIn('id',request('vechile_id'))->get();
        $Data['AuditorExpenseCategories'] = AuditorExpenseCategory::where([['clientid',auth()->user()->id],['type','expense']])->get();
        $Data['Accounts'] = Account::where([['clientid',auth()->user()->id]])->get();
        $Data['EntryData'] = Entry::whereIn('vehicleId',request('vechile_id'))->whereBetween('dateFrom', [request('date_from'), request('date_to')])->get();

        $Data['income']['entry'] =  Entry::where([['clientid',auth()->user()->id]])->whereIn('vehicleId',request('vechile_id'))->whereBetween('dateFrom', [request('date_from'), request('date_to')])->get()->groupBy('account_id')->map(function ($row) {
            return $row->sum('advance');
        })->toArray();
        $Data['income']['Income'] =  Income::where([['clientid',auth()->user()->id]])->whereIn('vehicleId',request('vechile_id'))->whereBetween('date', [request('date_from'), request('date_to')])->get()->groupBy('account_id')->map(function ($row) {
            return $row->sum('recevingAmount');
        })->toArray();

//        dd($Data['income']);


        foreach (array_keys($Data['income']['entry']) as $IncomeKey){
            if(array_key_exists($IncomeKey,$Data['income']['entry'])){
                $IncomeTotal[$IncomeKey]=@$Data['income']['entry'][$IncomeKey] + @$Data['income']['Income'][$IncomeKey];
            }
        }
        foreach (array_keys($Data['income']['Income']) as $ExpenseKey){
            if(!array_key_exists($ExpenseKey,$Data['income']['Income'])){
                $IncomeTotal[$ExpenseKey]=$Data['income']['Income'][$ExpenseKey];
            }
        }
        $Data['fright_charge'] = $IncomeTotal;

        $AuditorIncomeCategories =  AuditorExpenseCategory::where([['clientid',auth()->user()->id],['type','income']])->join('auditor_expense_types','auditor_expense_types.auditor_expense_category_id','=','auditor_expense_categories.id')->get()->groupBy('category');
        foreach($AuditorIncomeCategories as $key=>$AuditorIncomeCategory){
            $ExtraIncomeDatas =  ExtraIncome::where([['clientid',auth()->user()->id]])->whereIn('expense_type',$AuditorIncomeCategory->pluck('expense_type_id'))->whereIn('vehicleId',request('vechile_id'))->whereBetween('date', [request('date_from'), request('date_to')])->get()->groupBy('account_id')->map(function ($row) {
                return $row->sum('amount');
            });
            $Data['IncomeAmount'][$key]['amount'] = $ExtraIncomeDatas->toArray();
        }
        $Data['AuditorIncomeCategories'] = AuditorExpenseCategory::where([['clientid',auth()->user()->id],['type','income']])->get();

        return view('client.auditor.report.summery.report',$Data);
    }
}
