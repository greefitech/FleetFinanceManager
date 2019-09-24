<?php

namespace App\Http\Controllers\ManagerController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entry;
use App\Expense;
use App\ExpenseType;
use App\Vehicle;
use Excel;

class ReportController extends Controller
{

    public function __construct(){
        $this->middleware('manager');
        $this->ExpenseType = new ExpenseType;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Data['ExpenseTypes'] =  $this->ExpenseType::where([['clientid',auth()->user()->Owner->id],['managerid',auth()->user()->id]])->orWhereNull('clientid')->get();
        return view('manager.Report.Expense_report',$Data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function DownloadExpenseReport(){
       // return request()->all();
        $this->validate(request(),[
            'vehicleId'=>'required|exists:vehicles,id',
            'expense_type'=>'required|array',
        ]);
        $Vehicle = Vehicle::findorfail(request('vehicleId'));

        if(in_array(1,request('expense_type'))){
            if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                $Entry =  Entry::select(['dateFrom AS date'])->where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereBetween('dateFrom', [request('dateFrom'), request('dateTo')])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
            }else{
                $Entry =  Entry::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->select(['*','dateFrom as date'])->orderBy('dateFrom')->get();
                $Expenses =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
            }

            $FinalSelectDatas = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
            $FinalSelectDatas = $FinalSelectDatas->merge($Entry);
            $FinalSelectDatas = $FinalSelectDatas->merge($Expenses);

            $FinalSelectDatas->sortBy('date');

        }else{
            if(!empty(request('dateFrom')) && !empty(request('dateTo'))){
                $FinalSelectDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->whereBetween('date', [request('dateFrom'), request('dateTo')])->orderBy('date')->get();
            }else{
                $FinalSelectDatas =  Expense::where([['clientid',auth()->user()->id],['vehicleId',request('vehicleId')]])->whereIn('expense_type',request('expense_type'))->orderBy('date')->get();
            }

        }

        foreach ($FinalSelectDatas as $key => $value) {
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
                $Amount = $value->driverPadiAmount + $value->cleanerPadiAmount;
            }
            $finalData[] =array(
                'Date' => $value->date,
                'Expense Type' => $ExpenseType,
                'Staff Name' => @$StaffName,
                'Quantity' => $value->quantity,
                'Amount' => $Amount,
                'Location' => $value->location,
            );
        }

        $finalData[] =array();
        $finalData[] =array(
            'Date' => '',
            'Expense Type' => 'Total ',
            'Staff Name' => '',
            'Quantity' => '',
            'Amount' => $FinalSelectDatas->sum('amount') + $FinalSelectDatas->sum('driverPadiAmount') + $FinalSelectDatas->sum('cleanerPadiAmount'),
            'Location' => '',
        );

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
