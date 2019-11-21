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
        // return auth()->user()->id;
       // return request()->all();
        $this->validate(request(),[
            'vehicleId'=>'required|exists:vehicles,id',
            'expense_type'=>'required|array',
            'report_wise'=>'required|array',
        ]);
        $Vehicle = Vehicle::findorfail(request('vehicleId'));
        $FinalExpenseDatas = '';
        $FinalIncomeDatas = '';
        $FinalNonTripExpenseDatas = '';
        $FinalExtraIncomeDatas = '';
        if(in_array('expense',request('report_wise'))){
            if(in_array(1,request('expense_type'))){
                if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                    $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                    $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
                }else{
                    $Entry =  Entry::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                    $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
                }

                $FinalExpenseDatas = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
                $FinalExpenseDatas = $FinalExpenseDatas->merge($Entry)->merge($Expenses);
            }else{
                if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                    $FinalExpenseDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
                }else{
                    $FinalExpenseDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
                }

            }
        }

        if(in_array('income',request('report_wise'))){
            if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                $Incomes =  Income::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
            }else{
                $Entry =  Entry::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                $Incomes =  Income::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->orderBy('date')->get();
            }

            $FinalIncomeDatas = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
            $FinalIncomeDatas = $FinalIncomeDatas->merge($Entry)->merge($Incomes);
        }

        if(in_array('non_trip_expense',request('report_wise'))){
            if(in_array(1,request('expense_type'))){
                if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                    $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                    $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')],['tripId','=',NULL]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
                }else{
                    $Entry =  Entry::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                    $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')],['tripId','=',NULL]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
                }

                $FinalNonTripExpenseDatas = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
                $FinalNonTripExpenseDatas = $FinalNonTripExpenseDatas->merge($Entry)->merge($Expenses);
            }else{
                if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                    $FinalNonTripExpenseDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
                }else{
                    $FinalNonTripExpenseDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
                }

            }
        }

        if(in_array('extra_income',request('report_wise'))){
            if(in_array(1,request('expense_type'))){
                if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                    $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                    $ExtraIncomes =  ExtraIncome::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
                }else{
                    $Entry =  Entry::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                    $ExtraIncomes =  ExtraIncome::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
                }

                $FinalExtraIncomeDatas = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
                $FinalExtraIncomeDatas = $FinalExtraIncomeDatas->merge($Entry)->merge($ExtraIncomes);
            }else{
                if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                    $FinalExtraIncomeDatas =  ExtraIncome::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
                }else{
                    $FinalExtraIncomeDatas =  ExtraIncome::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
                }

            }
        }
       
        $merged = collect($FinalExpenseDatas)->merge($FinalIncomeDatas)->merge($FinalNonTripExpenseDatas)->merge($FinalExtraIncomeDatas);
        return $FinalSelectDatas = $merged->all();
        foreach ($FinalSelectDatas as $key => $value) {
            if(in_array('expense',request('report_wise'))){
                if(!empty($value->ExpenseType->expenseType)){
                    $ExpenseType = @$value->ExpenseType->expenseType;
                }else{
                    $ExpenseType = 'டிரைவர் படி';
                }
                $StaffName='';
                if(!empty($value->dateFrom)){
                    $StaffName = $value->Trip->Staff1->name;
                }
                if(!empty($value->amount)){
                    $Amount = @$value->amount;
                }else{
                    $Amount = @$value->driverPadiAmount + @$value->cleanerPadiAmount;
                }
                $finalData[] =array(
                    'Date' => @$value->date,
                    'Expense Type' => $ExpenseType,
                    'Staff Name' => @$StaffName,
                    'Quantity' => @$value->quantity,
                    'Amount' => $Amount,
                    'Location' => @$value->location,
                );
            }
            if(in_array('income',request('report_wise'))){
                if(!empty($value->Trip->tripName)){
                    $TripName = @$value->Trip->tripName;
                }else{
                    $TripName = '';
                }
                $StaffName='';
                if(!empty($value->dateFrom)){
                    $StaffName = $value->Trip->Staff1->name;
                }
                if(!empty($value->recevingAmount)){
                    $Amount = $value->recevingAmount;
                }
                $finalData[] =array(
                    'Date' => @$value->date,
                    'Expense Type' => $TripName,
                    'Staff Name' => @$StaffName,
                    'Quantity' => @$value->quantity,
                    'Amount' => @$Amount,
                    'Location' => @$value->location,
                );
            }

            if(in_array('non_trip_expense',request('report_wise'))){
                
            }

            if(in_array('extra_income',request('report_wise'))){
                
            }
        }

        return 1;
        $finalData[] =array();
        if(in_array('income',request('report_wise'))){
            $finalData[] =array(
                'Date' => '',
                'Expense Type' => 'Total ',
                'Staff Name' => '',
                'Quantity' => '',
                'Amount' => @$FinalSelectDatas->sum('recevingAmount'),
                'Location' => '',
            );
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
