<?php

namespace App\Http\Controllers\ClientController\Auditor;

use App\Entry;
use App\Expense;
use App\ExtraIncome;
use App\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class FullReportController extends Controller
{
    public function DownloadFullReport(){
        $this->validate(request(),[
            'vechile_id'=>'required',
            'date_from'=>'required|date',
            'date_to'=>'required|date',
        ]);
        $EntryDatas = Entry::whereIn('vehicleId',request('vechile_id'))->whereBetween('dateFrom', [request('date_from'), request('date_to')])->get();
        $ExpenseDatas = Expense::whereIn('vehicleId',request('vechile_id'))->whereBetween('date', [request('date_from'), request('date_to')])->get();
        $ExtraIncomeDatas = ExtraIncome::whereIn('vehicleId',request('vechile_id'))->whereBetween('date', [request('date_from'), request('date_to')])->get();
        $IncomeDatas = Income::whereIn('vehicleId',request('vechile_id'))->whereBetween('date', [request('date_from'), request('date_to')])->get();

        $finalData = $this->FullReportArray($EntryDatas,$ExpenseDatas,$ExtraIncomeDatas,$IncomeDatas);

        array_multisort(array_map('strtotime',array_column($finalData,'Date')),SORT_ASC,$finalData);
        if(!empty($finalData)){
            Excel::create(auth()->user()->transportName.' Report - '.date('Y-m-d'),function($excel) use ($finalData){
                $excel->sheet('Income Expense Detail',function($sheet) use ($finalData){
                    $sheet->fromArray($finalData);
                });
            })->export('xlsx');
        }else{
            return back()->with('danger','Something Went Wrong!');
        }
    }


    public function FullReportArray($EntryDatas,$ExpenseDatas,$ExtraIncomeDatas,$IncomeDatas){
        $finalData= array();
        foreach ($EntryDatas as $EntryData){
            $finalData[] = array(
                'Date'=> date("d-m-Y", strtotime($EntryData->dateFrom)),
                'Type'=>'Advance',
                'Account'=>$EntryData->account_id==1?'Cash':$EntryData->Account->account,
                'Income'=>$EntryData->advance,
                'Expense'=>'',
                'Description'=>''
            );
            $finalData[] = array(
                'Date'=> date("d-m-Y", strtotime($EntryData->dateFrom)),
                'Type'=>'Driver Padi',
                'Account'=>'Cash',
                'Income'=>'',
                'Expense'=>$EntryData->driverPadiAmount,
                'Description'=>''
            );
            $finalData[] = array(
                'Date'=> date("d-m-Y", strtotime($EntryData->dateFrom)),
                'Type'=>'Cleaner Padi',
                'Account'=>'Cash',
                'Income'=>'',
                'Expense'=>$EntryData->cleanerPadiAmount,
                'Description'=>''
            );
            $finalData[] = array(
                'Date'=> date("d-m-Y", strtotime($EntryData->dateFrom)),
                'Type'=>'Loading Mamool',
                'Account'=>'Cash',
                'Income'=>'',
                'Expense'=>$EntryData->loadingMamool,
                'Description'=>''
            );
            $finalData[] = array(
                'Date'=> date("d-m-Y", strtotime($EntryData->dateFrom)),
                'Type'=>'UnLoading Mamool',
                'Account'=>'Cash',
                'Income'=>'',
                'Expense'=>$EntryData->unLoadingMamool,
                'Description'=>''
            );
            $finalData[] = array(
                'Date'=> date("d-m-Y", strtotime($EntryData->dateFrom)),
                'Type'=>'Comission',
                'Account'=>'Cash',
                'Income'=>'',
                'Expense'=>$EntryData->comission,
                'Description'=>''
            );

        }
        foreach ($ExpenseDatas as $ExpenseData) {
            $finalData[] = array(
                'Date' => date("d-m-Y", strtotime($ExpenseData->date)),
                'Type' => $ExpenseData->ExpenseType->expenseType,
                'Account' => $ExpenseData->account_id == 1 ? 'Cash' : $ExpenseData->Account->account,
                'Income' => '',
                'Expense' => $ExpenseData->amount,
                'Description'=>''
            );
        }
        foreach ($ExtraIncomeDatas as $ExtraIncomeData) {
            $finalData[] = array(
                'Date' => date("d-m-Y", strtotime($ExtraIncomeData->date)),
                'Type' => $ExtraIncomeData->ExpenseType->expenseType,
                'Account' => $ExtraIncomeData->account_id == 1 ? 'Cash' : $ExtraIncomeData->Account->account,
                'Income' => $ExtraIncomeData->amount,
                'Expense' => '',
                'Description'=>'',
                'Description'=>''
            );
        }
        foreach ($IncomeDatas as $IncomeData) {
            $finalData[] = array(
                'Date' => date("d-m-Y", strtotime($IncomeData->date)),
                'Type' => 'Income',
                'Account' => $IncomeData->account_id == 1 ? 'Cash' : $IncomeData->Account->account,
                'Income' => $IncomeData->recevingAmount,
                'Expense' => '',
                'Description'=>''
            );
        }
        return $finalData;
    }
}
