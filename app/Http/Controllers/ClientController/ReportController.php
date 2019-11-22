<?php

namespace App\Http\Controllers\ClientController;

use App\Entry;
use App\Expense;
use App\ExpenseType;
use App\Vehicle;
use App\Income;
use App\ExtraIncome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class ReportController extends Controller
{

    public function __construct(){
        $this->middleware('client');
        $this->ExpenseType = new ExpenseType;
    }

    public function ExpenseReport(){
        $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->get();
        return view('client.report.expense-report',$Data);
    }

    public function DownloadExpenseReport(){
        $this->validate(request(),[
            'dateFrom'=>'required|date',
            'dateTo'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'expense_type'=>'required|array',
            'report_wise'=>'required|array',
        ]);
        $Vehicle = Vehicle::findorfail(request('vehicleId'));
        $FinalExpenseDatas = '';
        $FinalIncomeDatas = '';
        $FinalNonTripExpenseDatas = '';
        $FinalExtraIncomeDatas = '';
        // dd(request()->all());

        if(in_array('expense',request('report_wise'))){
            if(in_array('cleaner_padi',request('expense_type')) || in_array('driver_padi',request('expense_type'))|| in_array('export',request('expense_type'))|| in_array('import',request('expense_type'))|| in_array('commission',request('expense_type'))){
                $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->whereNotNull('tripId')->orderBy('date')->get();
                $FinalExpenseDatas = new \Illuminate\Database\Eloquent\Collection; 
                $FinalExpenseDatas = $FinalExpenseDatas->merge($Entry)->merge($Expenses);
            }else{
                $FinalExpenseDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
            }
        }


        if(in_array('income',request('report_wise'))){
            $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->whereNotNull('advance')->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
            $Incomes =  Income::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('date', [request('dateFrom'), request('dateTo')])->whereNotNull('recevingAmount')->orderBy('date')->get();
            $FinalIncomeDatas = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
            $FinalIncomeDatas = $FinalIncomeDatas->merge($Entry)->merge($Incomes);
        }


        if(in_array('non_trip_expense',request('report_wise'))){
            $FinalNonTripExpenseDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->whereNull('tripId')->orderBy('date')->get();            
        }



        if(in_array('extra_income',request('report_wise'))){
            $FinalExtraIncomeDatas =  ExtraIncome::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->select(['*','amount as extraincome'])->orderBy('date')->get();
        }
       

        $merged = collect($FinalExpenseDatas)->merge($FinalIncomeDatas)->merge($FinalNonTripExpenseDatas)->merge($FinalExtraIncomeDatas);


        $FinalSelectDatas = $merged->all();

        foreach ($FinalSelectDatas as $key => $DataValue) {
            //income
            if(in_array('income',request('report_wise'))){
                if(isset($DataValue->advance)){
                    $finalData[] =array(
                        'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                        'Description' => @$DataValue->customer->name.'  -  '.@$DataValue->Trip->tripName,
                        'Credit' => @$DataValue->advance,
                        'Debit' => '',
                        'Quantity' => @$DataValue->quantity,
                        'Staff Name' => '',
                        'Location' => @$DataValue->location,
                        'Payment Status' => '',
                    );
                }
                if(isset($DataValue->recevingAmount)){
                    $finalData[] =array(
                        'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                        'Description' => @$DataValue->customer->name.'  -  '.@$DataValue->Trip->tripName,
                        'Credit' => @$DataValue->recevingAmount,
                        'Debit' => '',
                        'Quantity' => @$DataValue->quantity,
                        'Staff Name' => '',
                        'Location' => @$DataValue->location,
                        'Payment Status' => '',
                    );
                }
            }
            //Extra income
            if(in_array('extra_income',request('report_wise'))){
                if(isset($DataValue->extraincome)){
                    $finalData[] =array(
                        'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                        'Description' => @$DataValue->ExpenseType->expenseType,
                        'Credit' => @$DataValue->extraincome,
                        'Debit' => '',
                        'Quantity' => '',
                        'Staff Name' => '',
                        'Location' => @$DataValue->location,
                        'Payment Status' => '',
                    );
                }
            }

            // non trip expense
            if(in_array('non_trip_expense',request('report_wise'))){
                if(isset($DataValue->amount) && empty($DataValue->tripId)){
                    $finalData[] =array(
                        'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                        'Description' => @$DataValue->ExpenseType->expenseType,
                        'Credit' => '',
                        'Debit' => @$DataValue->amount,
                        'Quantity' => '',
                        'Staff Name' => '',
                        'Location' => @$DataValue->location,
                        'Payment Status' => '',
                    );
                }
            }

            // non trip expense
            if(in_array('expense',request('report_wise'))){
                if(isset($DataValue->amount) && !empty($DataValue->tripId)){
                    $finalData[] =array(
                        'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                        'Description' => @$DataValue->ExpenseType->expenseType,
                        'Credit' => '',
                        'Debit' => @$DataValue->amount,
                        'Quantity' => @$DataValue->quantity,
                        'Staff Name' => '',
                        'Location' => @$DataValue->location,
                        'Payment Status' => '',
                    );
                }    

                if(in_array('cleaner_padi',request('expense_type'))){
                    if(isset($DataValue->cleanerPadiAmount) && !empty($DataValue->cleanerPadiAmount)){
                        $finalData[] =array(
                            'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                            'Description' => 'Cleaner Padi  -  '.@$DataValue->Trip->tripName,
                            'Credit' => '',
                            'Debit' => @$DataValue->cleanerPadiAmount,
                            'Quantity' => '',
                            'Staff Name' => '',
                            'Location' => '',
                            'Payment Status' => '',
                        );
                    }
                } 
                if(in_array('driver_padi',request('expense_type'))){
                    if(isset($DataValue->driverPadiAmount) && !empty($DataValue->driverPadiAmount)){
                        $finalData[] =array(
                            'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                            'Description' => 'Driver Padi  -  '.@$DataValue->Trip->tripName,
                            'Credit' => '',
                            'Debit' => @$DataValue->driverPadiAmount,
                            'Quantity' => '',
                            'Staff Name' => '',
                            'Location' => '',
                            'Payment Status' => '',
                        );
                    }
                }    
                if(in_array('export',request('expense_type'))){
                    if(isset($DataValue->loadingMamool) && !empty($DataValue->loadingMamool)){
                        $finalData[] =array(
                            'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                            'Description' => 'Loading Momool  -  '.@$DataValue->Trip->tripName,
                            'Credit' => '',
                            'Debit' => @$DataValue->loadingMamool,
                            'Quantity' => '',
                            'Staff Name' => '',
                            'Location' => '',
                            'Payment Status' => '',
                        );
                    }
                }  

                if(in_array('import',request('expense_type'))){
                    if(isset($DataValue->unLoadingMamool) && !empty($DataValue->unLoadingMamool)){
                        $finalData[] =array(
                            'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                            'Description' => 'UnLoading Momool  -  '.@$DataValue->Trip->tripName,
                            'Credit' => '',
                            'Debit' => @$DataValue->unLoadingMamool,
                            'Quantity' => '',
                            'Staff Name' => '',
                            'Location' => '',
                            'Payment Status' => '',
                        );
                    }
                }

                if(in_array('commission',request('expense_type'))){
                    if(isset($DataValue->comission) && !empty($DataValue->comission)){
                        $finalData[] =array(
                            'Date' => date("d-m-Y", strtotime(@$DataValue->date)),
                            'Description' => 'Comission  -  '.@$DataValue->Trip->tripName,
                            'Credit' => '',
                            'Debit' => @$DataValue->comission,
                            'Quantity' => '',
                            'Staff Name' => '',
                            'Location' => '',
                            'Payment Status' => '',
                        );
                    }
                }
            }
        }

        if(!empty($finalData)){
            Excel::create($Vehicle->vehicleNumber.' - Report - '.date('Y-m-d'),function($excel) use ($finalData,$Vehicle){
                $excel->sheet('Sheet 1',function($sheet) use ($finalData,$Vehicle){
                    $sheet->setTitle($Vehicle->vehicleNumber.' Report');

                    $sheet->fromArray($finalData);
                });
            })->export('xlsx');
        }else{
            return back()->with('danger','Something Went Wrong!');
        }
    }
}
