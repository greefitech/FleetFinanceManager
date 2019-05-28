<?php

namespace App\Http\Controllers\ClientController;

use App\Entry;
use App\Expense;
use App\Halt;
use App\Income;
use App\Trip;
use PDF;
use App\TripAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripSheetController extends Controller
{
    public function DownloadTripSheet($tripId){
        $TripSheetModel = auth()->user()->memosheet;  // Get Memo Function
        return $this->$TripSheetModel($tripId);  // Memo Function Redirect
    }

    public function DefaultTripSheet($tripId){    //Default Trip Sheet
        $Data['Trip'] = Trip::findorfail($tripId);
        @$Data['entryDatas'] = Entry::where([['tripId',$tripId]])->orderBy('dateFrom')->get();
        @$Data['Incomes'] = Income::where([['tripId',$tripId]])->orderBy('date')->get();
        @$Data['Diesels'] = Expense::where([['expense_type',2],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['RTO'] = Expense::where([['expense_type',4],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['PC'] = Expense::where([['expense_type',12],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['checkPost'] = Expense::where([['expense_type',11],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['pattarai'] = Expense::where([['expense_type',3],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['Halts'] =  Halt::where([['tripId',$tripId]])->orderBy('date')->get();
        @$Data['ExpenseNotPaid'] = Expense::where([['tripId',$tripId],['status',0]])->orderBy('date')->get();
        @$Data['Naakka'] = Expense::where([['expense_type',5],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['paalam'] = Expense::where([['expense_type',6],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['BillPadi'] = Expense::where([['expense_type',13],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['TripAmounts'] = TripAmount::where([['tripId',$tripId]])->orderBy('date')->get();
        @$Data['DriverExpenses'] = Expense::where([['expense_type','!=',1],['expense_type','!=',15],['expense_type','!=',3],['tripId',$tripId],['account_id',1],['status',1]])->orderBy('date')->get();
        @$Data['EntryCashAdvance'] = Entry::where([['tripId',$tripId],['account_id',1]])->orderBy('dateFrom')->get();
        @$Data['otherExpenses'] = Expense::where([['expense_type','!=',2],['expense_type','!=',1],['expense_type','!=',3],['expense_type','!=',4],['expense_type','!=',5],['expense_type','!=',6],['expense_type','!=',11],['expense_type','!=',12],['expense_type','!=',13],['tripId',$tripId],['status',1]])->orderBy('date')->get();
//        return view('client.tripWise.tripSheet', compact('entryDatas','Trip','Diesels','RTO','PC','checkPost','pattarai','otherExpenses','Naakka','paalam','BillPadi','Incomes','DriverExpenses','EntryCashAdvance','TripAmounts','ExpenseNotPaid','Halts'));
        $pdf = PDF::loadView('client.tripSheet.DefaultTripSheet', $Data)->setOption('encoding', 'UTF-8')->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

    public function KPRTripsheet($tripId){
        $Data['Trip']= Trip::findorfail($tripId);
        @$Data['entryDatas'] = Entry::where([['tripId',$tripId]])->orderBy('dateFrom')->get();
        @$Data['Incomes'] = Income::where([['tripId',$tripId]])->orderBy('date')->get();
        @$Data['Diesels'] = Expense::where([['expense_type',2],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['RTO'] = Expense::where([['expense_type',4],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['PC'] = Expense::where([['expense_type',12],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['checkPost'] = Expense::where([['expense_type',11],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['pattarai'] = Expense::where([['expense_type',3],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['Halts'] =  Halt::where([['tripId',$tripId]])->orderBy('date')->get();

        @$Data['ExpenseNotPaid'] = Expense::where([['tripId',$tripId],['status',0]])->orderBy('date')->get();

        @$Data['Naakka'] = Expense::where([['expense_type',5],['tripId',$tripId],['status',1]])->orderBy('date')->get();

        @$Data['paalam'] = Expense::where([['expense_type',6],['tripId',$tripId],['status',1]])->orderBy('date')->get();
        @$Data['BillPadi'] = Expense::where([['expense_type',13],['tripId',$tripId],['status',1]])->orderBy('date')->get();

        @$Data['TripAmounts'] = TripAmount::where([['tripId',$tripId]])->orderBy('date')->get();

        @$Data['DriverExpenses'] = Expense::where([['expense_type','!=',1],['expense_type','!=',15],['expense_type','!=',3],['tripId',$tripId],['account_id',1],['status',1]])->orderBy('date')->get();
        @$Data['EntryCashAdvance'] = Entry::where([['tripId',$tripId],['account_id',1]])->orderBy('dateFrom')->get();

        @$Data['otherExpenses']= Expense::where([['expense_type','!=',17],['expense_type','!=',2],['expense_type','!=',1],['expense_type','!=',3],['expense_type','!=',4],['expense_type','!=',5],['expense_type','!=',6],['expense_type','!=',11],['expense_type','!=',12],['expense_type','!=',13],['tripId',$tripId],['status',1]])->orderBy('date')->get();

        @$Data['TripOtherExpenses'] = Expense::where([['tripId',$tripId],['expense_type',17]])->orderBy('date')->get();
//        return view('client.tripWise.kpr_tripsheet', compact('entryDatas','Trip','Diesels','RTO','PC','checkPost','pattarai','otherExpenses','Naakka','paalam','BillPadi','Incomes','DriverExpenses','EntryCashAdvance','TripAmounts','ExpenseNotPaid','Halts','TripOtherExpenses'));
        $pdf = PDF::loadView('client.tripSheet.kpr_tripsheet', $Data)->setOption('encoding', 'UTF-8')->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }
}
